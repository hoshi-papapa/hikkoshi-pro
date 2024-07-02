<!-- タスク編集モーダル -->
<div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-mycolor3 text-mycolor1">
                <h5 class="modal-title" id="editTaskModalLabel{{ $task->id }}">タスク編集</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <form action="{{ route('tasks.update', $task) }}" method="POST">
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
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="sub_user_{{ $subUser->id }}_task_{{ $task->id }}" name="sub_users[]" value="{{ $subUser->id }}"
                                @if($task->subUsers->contains($subUser->id)) checked @endif>
                                <label class="form-check-label" for="sub_user_{{ $subUser->id }}_task_{{ $task->id }}">{{ $subUser->nickname }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" id="editCompleted" name="completed" value="{{ $task->completed }}">
                </div>
                <div class="modal-footer bg-mycolor3 text-mycolor1">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-danger btn-mycolor1">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
