@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px;">    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @if ($selectedSubUser)
                <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">やることリスト</a></li>
                <li class="breadcrumb-item active text-mycolor1" aria-current="page">{{ $selectedSubUser->nickname }}さんのやることリスト</li>
            @else
                <li class="breadcrumb-item active text-mycolor1" aria-current="page">やることリスト</li>
            @endif
        </ol>
    </nav>

    <!-- サブユーザー選択フォーム -->
    <form method="GET" action="{{ route('tasks.index') }}" id="subUserForm">
        <div class="form-group">
            <label for="sub_user_id">ユーザーを選択</label>
            <select name="sub_user_id" id="sub_user_id" class="form-control" onchange="document.getElementById('subUserForm').submit();">
                <option value="">すべてのユーザー</option>
                @foreach ($subUsers as $subUser)
                    <option value="{{ $subUser->id }}" {{ $selectedSubUserId == $subUser->id ? 'selected' : '' }}>
                        {{ $subUser->nickname }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    {{-- 目標の追加用モーダル --}}
    @include('modals.task-add-modal')
    
    <div class="text-center mt-3">
        <a href="#" class="btn btn-danger btn-mycolor1" data-bs-toggle="modal" data-bs-target="#addTaskModal">
            目標の追加
        </a>
    </div>
    <!-- タスク一覧表示 -->
    @if (empty($categorizedTasks))
        <p>タスクがありません。</p>
    @else
        @if (!empty($categorizedTasks['threeWeeksBefore']))
            <h4 class="mt-5">3週間前までに終わらせるタスク</h4>
            @include('tasks.partials.task-box', ['tasks' => $categorizedTasks['threeWeeksBefore']])

            @foreach ($categorizedTasks['threeWeeksBefore'] as $task)
                {{-- 目標の編集用モーダル --}}
                @include('modals.task-edit-modal', ['task' => $task])

                {{-- 目標の削除用モーダル --}}
                @include('modals.task-delete-modal', ['task' => $task])
            @endforeach
        @endif

        @if (!empty($categorizedTasks['twoWeeksBefore']))
            <h4 class="mt-5">2週間前までに終わらせるタスク</h4>
            @include('tasks.partials.task-box', ['tasks' => $categorizedTasks['twoWeeksBefore']])

            @foreach ($categorizedTasks['twoWeeksBefore'] as $task)
                {{-- 目標の編集用モーダル --}}
                @include('modals.task-edit-modal', ['task' => $task])

                {{-- 目標の削除用モーダル --}}
                @include('modals.task-delete-modal', ['task' => $task])
            @endforeach
        @endif

        @if (!empty($categorizedTasks['oneWeekBefore']))
            <h4 class="mt-5">1週間前までに終わらせるタスク</h4>
            @include('tasks.partials.task-box', ['tasks' => $categorizedTasks['oneWeekBefore']])

            @foreach ($categorizedTasks['oneWeekBefore'] as $task)
                {{-- 目標の編集用モーダル --}}
                @include('modals.task-edit-modal', ['task' => $task])

                {{-- 目標の削除用モーダル --}}
                @include('modals.task-delete-modal', ['task' => $task])
            @endforeach
        @endif

        @if (!empty($categorizedTasks['oneDayBefore']))
            <h4 class="mt-5">前日までに終わらせるタスク</h4>
            @include('tasks.partials.task-box', ['tasks' => $categorizedTasks['oneDayBefore']])

            @foreach ($categorizedTasks['oneDayBefore'] as $task)
                {{-- 目標の編集用モーダル --}}
                @include('modals.task-edit-modal', ['task' => $task])

                {{-- 目標の削除用モーダル --}}
                @include('modals.task-delete-modal', ['task' => $task])
            @endforeach
        @endif

        @if (!empty($categorizedTasks['movingDay']))
            <h4 class="mt-5">当日終わらせるタスク</h4>
            @include('tasks.partials.task-box', ['tasks' => $categorizedTasks['movingDay']])

            @foreach ($categorizedTasks['movingDay'] as $task)
                {{-- 目標の編集用モーダル --}}
                @include('modals.task-edit-modal', ['task' => $task])

                {{-- 目標の削除用モーダル --}}
                @include('modals.task-delete-modal', ['task' => $task])
            @endforeach
        @endif

        @if (!empty($categorizedTasks['oneWeekAfter']))
            <h4 class="mt-5">引っ越し後1週間以内に終わらせるタスク</h4>
            @include('tasks.partials.task-box', ['tasks' => $categorizedTasks['oneWeekAfter']])

            @foreach ($categorizedTasks['oneWeekAfter'] as $task)
                {{-- 目標の編集用モーダル --}}
                @include('modals.task-edit-modal', ['task' => $task])

                {{-- 目標の削除用モーダル --}}
                @include('modals.task-delete-modal', ['task' => $task])
            @endforeach
        @endif

        @if (!empty($categorizedTasks['earlyAfterMoving']))
            <h4 class="mt-5">引っ越し後早めに終わらせるタスク</h4>
            @include('tasks.partials.task-box', ['tasks' => $categorizedTasks['earlyAfterMoving']])

            @foreach ($categorizedTasks['earlyAfterMoving'] as $task)
                {{-- 目標の編集用モーダル --}}
                @include('modals.task-edit-modal', ['task' => $task])

                {{-- 目標の削除用モーダル --}}
                @include('modals.task-delete-modal', ['task' => $task])
            @endforeach
        @endif

        @if (!empty($categorizedTasks['completedTasks']))
            <h4 class="mt-5">完了したタスク</h4>
            @include('tasks.partials.task-box', ['tasks' => $categorizedTasks['completedTasks']])

            @foreach ($categorizedTasks['completedTasks'] as $task)
                {{-- 目標の編集用モーダル --}}
                @include('modals.task-edit-modal', ['task' => $task])

                {{-- 目標の削除用モーダル --}}
                @include('modals.task-delete-modal', ['task' => $task])
            @endforeach
        @endif

    @endif

    <div class="mt-5 text-mycolor1 help-box">
        <div class="mb-1">
            <i class="fa-solid fa-circle-info"></i> アイコンについて
        </div>
        <div class="row">
            <div class="col">
                <div class="card my-1 border-light-subtle">
                    <i class="far fa-circle icon-help" style="font-size: 1.5rem;"></i>
                    <div class="card-body">
                        <p class="card-text" style="text-align: center;">誰も完了していないタスクです</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card my-1 border-light-subtle">
                    <i class="fas fa-circle icon-help" style="font-size: 1.5rem;"></i>
                    <div class="card-body">
                        <p class="card-text" style="text-align: center;">誰かが完了していないタスクです</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card my-1 border-light-subtle">
                    <i class="fas fa-check-circle icon-help" style="font-size: 1.5rem;"></i>
                    <div class="card-body">
                        <p class="card-text" style="text-align: center;">全員が完了しているタスクです</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    
        document.querySelectorAll('.editTaskForm').forEach(function(form){
            form.addEventListener('submit', function(event){

                event.preventDefault();

                var modal = form.closest('.modal');

                // Ajaxでフォームを送信
                var formData = new FormData(this);

                fetch(this.action, {
                    method: this.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.errors) {
                        // バリデーションエラーがある場合はエラーメッセージを表示
                        handleFormErrors(data.errors, modal);
                    } else if (data.redirect) {
                        // 正常に作成できた場合はリダイレクト
                        window.location.href = data.redirect;
                    } else {
                        console.error('Unexpected response:', data);
                        alert('aaUnexpected error occurred. Please try again later.');
                    }
                })
                .catch(error => {
                    console.error('Unexpected error:', error);
                    alert('bbUnexpected error occurred. Please try again later.');
                });
            });

            function handleFormErrors(errors, modal) {
                var errorMessagesDiv = modal.querySelector('.editErrorMessages');
                errorMessagesDiv.classList.remove('d-none'); // エラーメッセージコンテナを表示

                var errorMessage = '<ul style="margin-bottom: 0;">';
                for (var key in errors) {
                    errorMessage += '<li>' + errors[key].join(', ') + '</li>';
                }
                errorMessage += '</ul>';

                errorMessagesDiv.innerHTML = errorMessage;
            }
        });
    
            // チェックボックスの状態変更を監視
        document.querySelectorAll('.sub-user-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var idParts = this.id.split('_');
                var taskId = idParts[idParts.length - 1]; // IDの最後の部分をtaskIdとして取得
                var subUserId = this.value;            

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

        //完了・未完了ボタンがクリックされたとき
        $('.status').on('click', function(){
            var subUserId = $('#sub_user_id').val();
            if (subUserId){
                var form = this.querySelector('form');
                form.querySelector('.toggle-completion-button').click();
            }
        });
        
    });    

</script>

@endsection