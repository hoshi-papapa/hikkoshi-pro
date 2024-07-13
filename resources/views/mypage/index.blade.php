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
            <li class="breadcrumb-item active text-mycolor1" aria-current="page">マイページ</li>
        </ol>
    </nav>

    <div class="card mt-3">
        <div class="card-header fs-5 bg-mycolor3 text-mycolor1">
            全体情報
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <th scope="row">引越予定日</th>
                        <td>{{ \Carbon\Carbon::parse($user->planned_moving_date)->format('Y年n月j日') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">電話番号</th>
                        <td>{{ $user->phone_number }}</td>
                    </tr>
                    <tr>
                        <th scope="row">メールアドレス</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-mycolor3 text-mycolor1 d-flex justify-content-center">
            <a href="{{ route('mypage.edit') }}" class="btn btn-danger btn-mycolor1">
                編集する
            </a>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header fs-5 bg-mycolor3 text-mycolor1">
            サブユーザー情報
        </div>
        <div class="card-body">
            <div class="row">        
                <!-- サブユーザーカード -->
                @foreach($subUsers as $subUser)
                <div class="col-md-4">
                            <p>{{ $subUser->user_image_path }}</p>
                    <a href="{{ route('subusers.edit', $subUser) }}" class="text-decoration-none text-dark">
                        <div class="card mb-4">
                            <img src="{{ $subUser->user_image_path ? $subUser->user_image_path : asset('images/default-avatar.png') }}" class="card-img-top" alt="{{ $subUser->nickname }}">
                            <div class="card-body text-mycolor1">
                                <h5 class="card-title">{{ $subUser->nickname }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

                <!-- サブユーザー追加カード -->
                <div class="col-md-4">
                    <div class="card mb-4" style="height: 92%">
                        <a href="{{ route('subusers.create') }}" class="text-center py-5 text-mycolor1" style="text-decoration: none;">
                            <h2>+</h2>
                            <p>サブユーザー追加</p>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- ログアウトボタン -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-3 d-inline d-flex justify-content-center">
        @csrf
        <button type="submit" class="btn btn-danger btn-mycolor1">ログアウト</button>
    </form>
</div>
@endsection
