<!-- resources/views/subusers/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>サブユーザー一覧</h1>
    <div class="row">        
        <!-- サブユーザーカード -->
        @foreach($subUsers as $subUser)
        <div class="col-md-4">
            <a href="{{ route('subusers.edit', $subUser) }}" class="text-decoration-none text-dark">
                <div class="card mb-4">
                    <img src="{{ $subUser->user_image_path ? asset('storage/' . $subUser->user_image_path) : asset('images/default-avatar.png') }}" class="card-img-top" alt="{{ $subUser->nickname }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $subUser->nickname }}</h5>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

        <!-- サブユーザー追加カード -->
        <div class="col-md-4">
            <div class="card mb-4">
                <a href="{{ route('subusers.create') }}" class="text-center py-5" style="text-decoration: none;">
                    <h2>+</h2>
                    <p>サブユーザー追加</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
