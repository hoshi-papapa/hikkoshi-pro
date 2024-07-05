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
        <ol class="breadcrumb" style="font-size: 1.75rem;">
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
    @if ($tasks->isEmpty())
        <p>タスクがありません。</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>完了・未完了</th>
                    <th>タイトル</th>
                    <th>説明</th>
                    <th>開始日</th>
                    <th>終了日</th>
                    <th>アクション</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    @foreach ($task->subUsers as $subUser)
                        @if ($selectedSubUserId == $subUser->id || !$selectedSubUserId)
                            <tr class="clickable-row">
                                <td>
                                    <form action="{{ route('tasks.toggleSubUserCompletion', ['subUser' => $subUser->id, 'task' => $task->id]) }}" method="POST">
                                        @csrf
                                        @method('patch')
                                        <button type="submit" class="btn btn-link p-0">
                                            @if ($subUser->pivot->completed)
                                                <i class="fas fa-check-circle"></i>
                                            @else
                                                <i class="far fa-circle"></i>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">{{ $task->title }}</td>
                                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">{{ $task->description }}</td>
                                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">{{ $task->start_date }}</td>
                                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">{{ $task->end_date }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete-button" data-bs-toggle="modal" data-bs-target="#deleteTaskModal{{ $task->id }}">削除</button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>

        @foreach ($tasks as $task)
            {{-- 目標の編集用モーダル --}}
            @include('modals.task-edit-modal')

            {{-- 目標の削除用モーダル --}}
            @include('modals.task-delete-modal')
        @endforeach
    @endif
</div>
@endsection