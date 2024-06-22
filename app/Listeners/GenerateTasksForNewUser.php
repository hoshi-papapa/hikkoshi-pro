<?php

namespace App\Listeners;

use App\Models\TemplateTask;
use App\Models\Task;
use App\Models\SubUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

class GenerateTasksForNewUser
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // ユーザー登録時にテンプレートタスクからタスクを生成
        $user = $event->user;
        $templateTasks = TemplateTask::all();

        //サブユーザーの作成
        $subUser = SubUser::create([
            'main_user_id' => $user->id,
            'nickname' => $user->name
        ]);

        foreach ($templateTasks as $templateTask) {
            $plannedMovingDate = Carbon::parse($user->planned_moving_date);

            $startDate = $plannedMovingDate->copy()->addDays($templateTask->start_date_offset);
            $endDate = $plannedMovingDate->copy()->addDays($templateTask->end_date_offset);

            $task = Task::create([
                'subuser_id' => $subUser->id,

                'title' => $templateTask->title,
                'description' => $templateTask->description,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'completed' => false,
                'is_template_task' => true,
                'template_task_id' => $templateTask->id
            ]);

            //サブユーザーにタスクを関連付け
            $subUser->tasks()->attach($task->id);
        }
    }
}
