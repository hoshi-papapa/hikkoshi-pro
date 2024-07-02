<!-- タスク詳細モーダル -->
<div class="modal fade" id="deleteTaskModal{{ $task->id }}" tabindex="-1" aria-labelledby="deleteTaskModalLabel{{ $task->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-mycolor3 text-mycolor1">
                <h5 class="modal-title" id="taskModalLabel">タスク削除</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <p>「{{ $task->title}}」を削除してもよろしいですか？</p>
            </div>
            <div class="modal-footer bg-mycolor3 text-mycolor1">
                <form action="{{ route('tasks.destroy', $task )}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-danger" data-task-id="">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>
