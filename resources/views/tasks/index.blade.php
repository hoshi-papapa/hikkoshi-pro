@extends('layouts.app')

@section('content')
<div class="container">
    <h1>タスク一覧</h1>

    <!-- サブユーザー選択フォーム -->
    <form method="GET" action="{{ route('tasks.index') }}">
        <div class="form-group">
            <label for="sub_user_id">サブユーザーを選択</label>
            <select name="sub_user_id" id="sub_user_id" class="form-control">
                <option value="">すべてのサブユーザー</option>
                @foreach ($subUsers as $subUser)
                    <option value="{{ $subUser->id }}" {{ $selectedSubUserId == $subUser->id ? 'selected' : '' }}>
                        {{ $subUser->nickname }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">表示</button>
    </form>

    {{-- 目標の追加用モーダル --}}
    @include('modals.task-add-modal')
    
    <div>
      <a href="#" class="link-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#addTaskModal">
        <div class="d-flex align-items-center">
          目標の追加
        </div>
      </a>
    </div>

    <!-- タスク一覧表示 -->
    @if ($tasks->isEmpty())
        <p>タスクがありません。</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>タイトル</th>
                    <th>説明</th>
                    <th>開始日</th>
                    <th>終了日</th>
                    <th>アクション</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    {{-- 目標の編集用モーダル --}}
                    @include('modals.task-edit-modal')

                    {{-- 目標の編集用モーダル --}}
                    @include('modals.task-delete-modal')

                    <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#taskModal" data-task="{{ $task }}">
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->start_date }}</td>
                        <td>{{ $task->end_date }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-button" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">編集</button>
                            <button class="btn btn-sm btn-danger delete-button" data-bs-toggle="modal" data-bs-target="#deleteTaskModal{{ $task->id }}">削除</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>


{{-- 

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var taskModal = document.getElementById('taskModal');
        var editTaskModal = document.getElementById('editTaskModal');

        taskModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var task = button.getAttribute('data-task');
            task = JSON.parse(task);

            document.getElementById('modalTaskTitle').textContent = task.title;
            document.getElementById('modalTaskDescription').textContent = task.description;
            document.getElementById('modalTaskStartDate').textContent = task.start_date;
            document.getElementById('modalTaskEndDate').textContent = task.end_date;
            document.getElementById('modalTaskCompleted').textContent = task.completed ? '完了' : '未完了';

            var deleteButton = taskModal.querySelector('.delete-button');
            deleteButton.setAttribute('data-task-id', task.id);
        });

        editTaskModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var task = button.getAttribute('data-task');
            task = JSON.parse(task);

            document.getElementById('editTaskId').value = task.id;
            document.getElementById('editTitle').value = task.title;
            document.getElementById('editDescription').value = task.description;
            document.getElementById('editStartDate').value = task.start_date;
            document.getElementById('editEndDate').value = task.end_date;
            document.getElementById('editCompleted').value = task.completed ? '1' : '0';
            document.getElementById('editForm').action = `/tasks/${task.id}`;
        });

        document.getElementById('editForm').addEventListener('submit', function (event) {
            event.preventDefault();
            var taskId = document.getElementById('editTaskId').value;
            var formData = new FormData(this);

            fetch(`/tasks/${taskId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'PUT' // PUTリクエストを使用
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('更新に失敗しました。');
                }
            });
        });

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function (event) {
                event.stopPropagation(); // イベントの伝播を停止

                var taskId = this.getAttribute('data-task-id');

                if (confirm('このタスクを削除しますか？')) {
                    fetch(`/tasks/${taskId}`, {
                        method: 'POST', // DELETEリクエストをエミュレートするためにPOSTを使用
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-HTTP-Method-Override': 'DELETE' // LaravelでDELETEリクエストを処理するためのヘッダー
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('削除に失敗しました。');
                        }
                    });
                } else {
                    // キャンセルされた場合、詳細モーダルを非表示にする
                    var taskModal = document.getElementById('taskModal');
                    var bootstrapModal = bootstrap.Modal.getInstance(taskModal);
                    bootstrapModal.hide();
                }
            });
        });
    });
</script> --}}
@endsection
