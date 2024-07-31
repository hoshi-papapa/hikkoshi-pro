<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\SubUser;
use App\Models\Task;
use App\Models\SubUserTask;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $subUsers = $user->subUsers;
        $selectedSubUserId = $request->input('sub_user_id');
        $selectedSubUser = $subUsers->find($selectedSubUserId);

        // メインユーザーに関連するサブユーザーのIDを取得
        $subUserIds = $subUsers->pluck('id')->toArray();

        // 条件に応じてタスクをフィルタリングし、関連するサブユーザーの情報をプリロードした状態でクエリを構築する
        $tasksQuery = Task::with('subUsers')
            ->whereHas('subUsers', function ($query) use ($subUserIds) {
                $query->whereIn('sub_user_id', $subUserIds);
            })
            ->when($selectedSubUserId, function ($query) use ($selectedSubUserId) {
                return $query->whereHas('subUsers', function ($query) use ($selectedSubUserId) {
                    $query->where('sub_user_id', $selectedSubUserId);
                });
            });

        $tasks = $tasksQuery->get();

        $plannedMovingDate = Carbon::parse($user->planned_moving_date)->startOfDay(); // ユーザーの引越予定日を取得し、日の最初に設定

        $threeWeeksBefore = $plannedMovingDate->copy()->subWeeks(3);
        $twoWeeksBefore = $plannedMovingDate->copy()->subWeeks(2);
        $oneWeekBefore = $plannedMovingDate->copy()->subWeeks(1);
        $oneDayBefore = $plannedMovingDate->copy()->subDays(1);
        $oneWeekAfter = $plannedMovingDate->copy()->addWeek();

        $categorizedTasks = [
            'threeWeeksBefore' => [],
            'twoWeeksBefore' => [],
            'oneWeekBefore' => [],
            'oneDayBefore' => [],
            'movingDay' => [],
            'oneWeekAfter' => [],
            'earlyAfterMoving' => [],
        ];

        foreach ($tasks as $task) {
            $endDate = Carbon::parse($task->end_date);

            if ($endDate->lt($threeWeeksBefore)) {
                $categorizedTasks['threeWeeksBefore'][] = $task;
            } elseif ($endDate->between($threeWeeksBefore, $twoWeeksBefore)) {
                $categorizedTasks['twoWeeksBefore'][] = $task;
            } elseif ($endDate->between($twoWeeksBefore, $oneWeekBefore)) {
                $categorizedTasks['oneWeekBefore'][] = $task;
            } elseif ($endDate->between($oneWeekBefore, $oneDayBefore)) {
                $categorizedTasks['oneDayBefore'][] = $task;
            } elseif ($endDate->isSameDay($plannedMovingDate)) {
                $categorizedTasks['movingDay'][] = $task;
            } elseif ($endDate->between($plannedMovingDate, $oneWeekAfter)) {
                $categorizedTasks['oneWeekAfter'][] = $task;
            } else {
                $categorizedTasks['earlyAfterMoving'][] = $task;
            }
        }


        // 各カテゴリ内のタスクを終了日が若い順番に並び替える
        foreach ($categorizedTasks as $category => $tasks) {
            usort($tasks, function ($a, $b) {
                $dateA = Carbon::parse($a->end_date);
                $dateB = Carbon::parse($b->end_date);
                return $dateA->lt($dateB) ? -1 : 1;
            });
            $categorizedTasks[$category] = $tasks;
        }

        return view('tasks.index', compact('tasks', 'categorizedTasks', 'subUsers', 'selectedSubUserId', 'selectedSubUser'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:32',
            'description' => 'nullable|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'sub_users' => [
                'required',
                Rule::exists('sub_users', 'id')->where(function ($query) {
                    $query->whereIn('id', request()->input('sub_users'));
                }),
            ],
        ], [
            'title.required' => 'タイトルは必ず入力してください。',
            'title.max' => 'タイトルは32文字まで入力できます。',
            'description.max' => 'タスクの内容は最大255文字まで入力できます。',
            'start_date.required' => '開始日は必ず指定してください。',
            'end_date.required' => '終了日は必ず指定してください。',
            'end_date.after_or_equal' => '終了日は開始日と同じか、それより後の日付を指定してください。',
            'sub_users.required' => 'サブユーザーを選択してください。',
            'sub_users.exists' => '選択されたサブユーザーが存在しません。',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');
        $task->completed = 0;
        $task->is_template_task = 0;
        $task->save();

        // 中間テーブルへの関連付け
        $subUserIds = $request->input('sub_users', []);
        if (!empty($subUserIds)) {
            $subUsers = SubUser::whereIn('id', $subUserIds)->get();
            $task->subUsers()->attach($subUsers);
        }

        //成功メッセージをフラッシュ
        Session::flash('success', 'タスクが作成されました。');

        //タスク一覧ページにリダイレクト
        return response()->json(['redirect' => route('tasks.index')]);
    }

    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:32',
            'description' => 'nullable|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'sub_users' => [
                'required',
                Rule::exists('sub_users', 'id')->where(function ($query) {
                    $query->whereIn('id', request()->input('sub_users'));
                }),
            ],
        ], [
            'title.required' => 'タイトルは必ず入力してください。',
            'title.max' => 'タイトルは32文字まで入力できます。',
            'description.max' => 'タスクの内容は最大255文字まで入力できます。',
            'start_date.required' => '開始日は必ず指定してください。',
            'end_date.required' => '終了日は必ず指定してください。',
            'end_date.after_or_equal' => '終了日は開始日と同じか、それより後の日付を指定してください。',
            'sub_users.required' => 'サブユーザーを選択してください。',
            'sub_users.exists' => '選択されたサブユーザーが存在しません。',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
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

        return redirect()->back()->with('success', 'タスクを更新しました。');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back()->with('success', 'タスクを削除しました。');
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
