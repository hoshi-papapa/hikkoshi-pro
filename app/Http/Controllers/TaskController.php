<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SubUser;
use App\Models\Task;
use App\Models\SubUserTask;
use Illuminate\Validation\Rule;


class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedSubUserId = $request->input('sub_user_id');

        if ($selectedSubUserId) {
            $tasks = Task::whereHas('subUsers', function ($query) use ($selectedSubUserId) {
                $query->where('sub_user_id', $selectedSubUserId);
            })->get();
            $selectedSubUser = SubUser::find($selectedSubUserId);
        } else {
            $tasks = Task::whereHas('subUsers', function ($query) use ($user) {
                $query->where('sub_users.main_user_id', $user->id);
            })->distinct()->get();
            $selectedSubUser = null;
        }

        $subUsers = SubUser::all();

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
        $task->completed = $request->has('completed');
        $task->is_template_task = 0; //編集したらテンプレートタスクから除外する
        $task->template_task_id = null;
        $task->save();

        // 中間テーブルへの関連付け
        $subUserIds = $request->input('sub_users', []);
        if (!empty($subUserIds)) {
            // 現在の関連付けを削除
            $task->subUsers()->detach();

            // 重複チェックを行い、新しい関連付けを作成
            foreach ($subUserIds as $subUserId) {
                $toggleKey = 'sub_user_toggle_' . $subUserId . '_task_' . $task->id;
                $completed = $request->has($toggleKey) ? true : false;

                $existingRecord = DB::table('subuser_tasks')
                    ->where('sub_user_id', $subUserId)
                    ->where('task_id', $task->id)
                    ->first();

                if (!$existingRecord) {
                    $task->subUsers()->attach($subUserId, ['completed' => $completed]);
                }
            }
        }

        return redirect()->route('tasks.index')->with('success', 'タスクを更新しました。');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }

    public function toggleSubUserCompletion(Task $task, SubUser $subUser)
    {
        $subUserTask = $task->subUsers()->where('sub_user_id', $subUser->id)->first();

        if ($subUserTask) {
            $completed = !$subUserTask->pivot->completed;
            $task->subUsers()->updateExistingPivot($subUser->id, ['completed' => $completed]);
        }

        return redirect()->back()->with('success', 'タスクの完了状態を変更しました。');
    }
}
