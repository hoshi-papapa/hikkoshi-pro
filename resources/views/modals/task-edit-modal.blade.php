<!-- タスク編集モーダル -->
<div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-mycolor3 text-mycolor1">
                <h5 class="modal-title" id="editTaskModalLabel{{ $task->id }}">タスク編集</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <form id="editTaskForm{{ $task->id }}" action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <input type="hidden" id="editTaskId" name="id" value="{{ $task->id }}">
                    <div class="form-group">
                        <label for="editTitle{{ $task->id }}">タイトル</label>
                        <input type="text" class="form-control" id="editTitle{{ $task->id }}" name="title" value="{{ $task->title }}">
                    </div>
                    <div class="form-group mt-3">
                        <label for="editDescription{{ $task->id }}">説明</label>
                        <textarea class="form-control" id="editDescription{{ $task->id }}" name="description">{{ $task->description }}</textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="editStartDate{{ $task->id }}">開始日</label>
                        <input type="date" class="form-control" id="editStartDate{{ $task->id }}" name="start_date" value="{{ $task->start_date }}">
                    </div>
                    <div class="form-group mt-3">
                        <label for="editEndDate{{ $task->id }}">終了日</label>
                        <input type="date" class="form-control" id="editEndDate{{ $task->id }}" name="end_date" value="{{ $task->end_date }}">
                    </div>
                    <div class="form-group mt-3">
                        <label>サブユーザーを選択</label><br>
                        @foreach ($subUsers as $subUser)
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input sub-user-checkbox" type="checkbox" id="sub_user_{{ $subUser->id }}_task_{{ $task->id }}" name="sub_users[]" value="{{ $subUser->id }}"
                                    @if($task->subUsers->contains($subUser->id)) checked @endif>
                                    <label class="form-check-label me-2" for="sub_user_{{ $subUser->id }}_task_{{ $task->id }}">{{ $subUser->nickname }}</label>
                                    <div class="form-check form-switch" id="sub_user_toggle_container_{{ $subUser->id }}_task_{{ $task->id }}" style="display: {{ $task->subUsers->contains($subUser->id) ? 'inline-block' : 'none' }};">
                                        <input class="form-check-input sub-user-toggle" type="checkbox" id="sub_user_toggle_{{ $subUser->id }}_task_{{ $task->id }}" name="sub_user_toggle_{{ $subUser->id }}_task_{{ $task->id }}" data-sub-user-id="{{ $subUser->id }}" data-task-id="{{ $task->id }}" {{ $task->subUsers->contains($subUser->id) && $task->subUsers->where('id', $subUser->id)->first()->pivot->completed ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sub_user_toggle_{{ $subUser->id }}_task_{{ $task->id }}">完了</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer bg-mycolor3 text-mycolor1">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-danger btn-mycolor1">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // チェックボックスの状態変更を監視
    document.querySelectorAll('.sub-user-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var subUserId = this.value;
            var taskId = this.id.split('_').pop(); // task_id を取得
            var toggleContainer = document.getElementById('sub_user_toggle_container_' + subUserId + '_task_' + taskId);
            var toggle = document.getElementById('sub_user_toggle_' + subUserId + '_task_' + taskId);
            if (this.checked) {
                toggleContainer.style.display = 'inline-block'; // トグルボタンを表示
            } else {
                toggleContainer.style.display = 'none'; // トグルボタンを非表示
                toggle.checked = false; // トグルボタンの値を false に設定
            }
        });
    });

    // フォームの送信時に隠しフィールドの値を更新
    document.querySelectorAll('.sub-user-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            var subUserId = this.dataset.subUserId;
            var taskId = this.dataset.taskId;
            var hiddenField = document.getElementById('editCompleted' + taskId);
            hiddenField.value = this.checked ? 1 : 0; // 隠しフィールドにトグルボタンの値を反映
        });
    });

    // 初期ロード時にチェックボックスの状態に応じてトグルボタンを表示/非表示
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.sub-user-checkbox').forEach(function(checkbox) {
            var subUserId = checkbox.value;
            var taskId = checkbox.id.split('_').pop(); // task_id を取得
            var toggleContainer = document.getElementById('sub_user_toggle_container_' + subUserId + '_task_' + taskId);
            if (checkbox.checked) {
                toggleContainer.style.display = 'inline-block'; // トグルボタンを表示
            } else {
                toggleContainer.style.display = 'none'; // トグルボタンを非表示
            }
        });
    });
</script>
