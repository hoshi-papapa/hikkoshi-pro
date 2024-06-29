@extends('layouts.app')

@section('content')
<div class="container">
    <h1>マイページ</h1>
    <div class="card">
        <div class="card-header">
            ユーザー情報
        </div>
        <div class="card-body">
            <p><strong>名前:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <!-- その他のユーザー情報 -->
        </div>
    </div>

    {{-- <div class="card mt-4">
        <div class="card-header">
            あなたのタスク
        </div>
        <div class="card-body">
            @if ($subUsers->isEmpty())
                <p>タスクはありません。</p>
            @else
                <ul class="list-group">
                    @foreach ($subUsers as $subUser)
                        <li class="list-group-item">
                            {{ $subUser->nickname }} - {{ $subUser->nickname }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div> --}}
</div>
@endsection
