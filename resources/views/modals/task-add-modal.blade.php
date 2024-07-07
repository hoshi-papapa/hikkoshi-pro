<!-- タスク追加モーダル -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-mycolor3 text-mycolor1">
                <h5 class="modal-title" id="addTaskModalLabel">タスク追加</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <form id="addTaskForm" action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
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
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input sub-user-checkbox" type="checkbox" id="sub_user_{{ $subUser->id }}" name="sub_users[]" value="{{ $subUser->id }}">
                                    <label class="form-check-label me-2" for="sub_user_{{ $subUser->id }}">{{ $subUser->nickname }}</label>
                                    <div class="form-check form-switch" id="sub_user_toggle_container_{{ $subUser->id }}" style="display: none;">
                                        <input class="form-check-input sub-user-toggle" type="checkbox" id="sub_user_toggle_{{ $subUser->id }}" name="sub_user_toggle_{{ $subUser->id }}" data-sub-user-id="{{ $subUser->id }}">
                                        <label class="form-check-label" for="sub_user_toggle_{{ $subUser->id }}">完了</label>
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
            var toggleContainer = document.getElementById('sub_user_toggle_container_' + subUserId);
            var toggle = document.getElementById('sub_user_toggle_' + subUserId);
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
            var hiddenField = document.getElementById('editCompleted' + subUserId);
            hiddenField.value = this.checked ? 1 : 0; // 隠しフィールドにトグルボタンの値を反映
        });
    });

</script>
