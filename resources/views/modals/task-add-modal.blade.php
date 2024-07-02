<!-- タスク編集モーダル -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-mycolor3 text-mycolor1">
                <h5 class="modal-title" id="addTaskModalLabel">タスク作成</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
                <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="addTaskId">
                    <div class="form-group">
                        <label for="addTitle">タイトル</label>
                        <input type="text" class="form-control" id="addTitle" name="title">
                    </div>
                    <div class="form-group mt-3">
                        <label for="addDescription">説明</label>
                        <textarea class="form-control" id="addDescription" name="description"></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="addStartDate">開始日</label>
                        <input type="date" class="form-control" id="addStartDate" name="start_date">
                    </div>
                    <div class="form-group mt-3">
                        <label for="addEndDate">終了日</label>
                        <input type="date" class="form-control" id="addEndDate" name="end_date">
                    </div>
                    <div class="form-group mt-3">
                        <label>サブユーザーを選択</label><br>
                        @foreach ($subUsers as $subUser)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="sub_user_{{ $subUser->id }}" name="sub_users[]" value="{{ $subUser->id }}">
                                <label class="form-check-label" for="sub_user_{{ $subUser->id }}">{{ $subUser->nickname }}</label>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" id="addCompleted" name="completed" value="0">
                </div>
                <div class="modal-footer bg-mycolor3 text-mycolor1">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-danger btn-mycolor1">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>