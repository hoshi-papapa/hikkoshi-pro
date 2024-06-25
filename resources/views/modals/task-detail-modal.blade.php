<!-- タスク詳細モーダル -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">タスク詳細</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <p><strong>タイトル:</strong> <span id="modalTaskTitle"></span></p>
                <p><strong>説明:</strong> <span id="modalTaskDescription"></span></p>
                <p><strong>開始日:</strong> <span id="modalTaskStartDate"></span></p>
                <p><strong>終了日:</strong> <span id="modalTaskEndDate"></span></p>
                <p><strong>完了状態:</strong> <span id="modalTaskCompleted"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                <button type="button" class="btn btn-primary edit-button" data-bs-toggle="modal" data-bs-target="#editTaskModal">編集</button>
                <button type="button" class="btn btn-danger delete-button" data-task-id="">削除</button>
            </div>
        </div>
    </div>
</div>
