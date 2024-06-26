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
            <li class="breadcrumb-item active text-mycolor1" aria-current="page">やることリスト</li>
        </ol>
    </nav>

    <!-- サブユーザー選択フォーム -->
    <form method="GET" action="{{ route('tasks.index') }}">
        <div class="form-group">
            <label for="sub_user_id">ユーザーを選択</label>
            <select name="sub_user_id" id="sub_user_id" class="form-control">
                <option value="">すべてのユーザー</option>
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

                    {{-- 目標の削除用モーダル --}}
                    @include('modals.task-delete-modal')

                    <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">
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
@endsection