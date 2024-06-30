<!-- サブユーザー削除モーダル -->
<div class="modal fade" id="deleteSubuserModal" tabindex="-1" aria-labelledby="deleteSubuserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSubuserModalLabel">ユーザー削除</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <p>{{ $subUser->nickname }}さんを削除してもよろしいですか？</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('subusers.destroy', $subUser->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-danger delete-button" data-task-id="">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>
