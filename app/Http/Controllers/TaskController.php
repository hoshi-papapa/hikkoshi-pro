<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubUser;
use App\Models\Task;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedSubUserId = $request->input('sub_user_id');

        if ($selectedSubUserId) {
            $tasks = Task::whereHas('subUsers', function ($query) use ($selectedSubUserId) {
                $query->where('sub_users.id', $selectedSubUserId);
            })->get();
            $selectedSubUser = SubUser::find($selectedSubUserId);
        } else {
            $tasks = Task::whereHas('subUsers', function ($query) use ($user) {
                $query->where('sub_users.main_user_id', $user->id);
            })->get()->unique('id');
            $selectedSubUser = null;
        }

        $subUsers = SubUser::where('main_user_id', $user->id)->get();

        return view('tasks.index', [
            'tasks' => $tasks,
            'subUsers' => $subUsers,
            'selectedSubUserId' => $selectedSubUserId,
            'selectedSubUser' => $selectedSubUser,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'sub_users' => [
                'required',
                Rule::exists('sub_users', 'id')->where(function ($query) {
                    $query->whereIn('id', request()->input('sub_users'));
                }),
            ],
        ], [
            'sub_users.required' => 'サブユーザーを選択してください。',
            'sub_users.exists' => '選択されたサブユーザーが存在しません。',
        ]);

        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');
        $task->completed = 0;
        $task->is_template_task = 0;
        $task->save();

        //中間テーブルへの関連付け
        $subUserIds = $request->input('sub_users', []);
        if (!empty($subUserIds)) {
            $subUsers = SubUser::whereIn('id', $subUserIds)->get();
            $task->subUsers()->attach($subUsers);
        }
        return redirect()->route('tasks.index');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'sub_users' => [
                'required',
                Rule::exists('sub_users', 'id')->where(function ($query) {
                    $query->whereIn('id', request()->input('sub_users'));
                }),
            ],
        ], [
            'sub_users.required' => 'サブユーザーを選択してください。',
            'sub_users.exists' => '選択されたサブユーザーが存在しません。',
        ]);

        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');
        $task->completed =  $request->input('completed');
        $task->is_template_task = 0; //編集したらテンプレートタスクから除外する
        $task->template_task_id = null;
        $task->save();

        //中間テーブルへの関連付け
        $subUserIds = $request->input('sub_users', []);
        if (!empty($subUserIds)) {
            $subUsers = SubUser::whereIn('id', $subUserIds)->get();
            $task->subUsers()->attach($subUsers);
        }
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }

    public function toggleCompletion(Task $task)
    {
        $wasCompleted = $task->completed;
        $task->completed = !$task->completed;
        $task->save();

        $message = $wasCompleted ? 'タスクを未完了にしました。' : 'タスクを完了しました。';

        return redirect()->route('tasks.index')->with('success', $message);
    }
}
