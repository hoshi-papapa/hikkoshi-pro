@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px;">
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: 1.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('mypage.index') }}">マイページ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザー情報変更</li>
        </ol>
    </nav>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('mypage.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- 引越予定日 -->
                <div class="form-group">
                    <label for="planned_moving_date" class="col-form-label">引越予定日</label>
                    <input type="date" class="form-control" id="planned_moving_date" name="planned_moving_date" value="{{ old('planned_moving_date', $user->planned_moving_date) }}" required autofocus autocomplete="planned_moving_date">
                    @if ($errors->has('planned_moving_date'))
                        <div class="mt-2 text-danger">{{ $errors->first('planned_moving_date') }}</div>
                    @endif
                </div>

                <!-- 電話番号 -->
                <div class="form-group mt-4">
                    <label for="phone_number" class="col-form-label">電話番号</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required autofocus autocomplete="phone_number">
                    @if ($errors->has('phone_number'))
                        <div class="mt-2 text-danger">{{ $errors->first('phone_number') }}</div>
                    @endif
                </div>

                <!-- Email Address -->
                <div class="form-group mt-4">
                    <label for="email" class="col-form-label">メールアドレス</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @if ($errors->has('email'))
                        <div class="mt-2 text-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <!-- Password -->
                <div class="form-group mt-4">
                    <label for="password" class="col-form-label">パスワード</label>
                    <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                    @if ($errors->has('password'))
                        <div class="mt-2 text-danger">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="form-group mt-4">
                    <label for="password_confirmation" class="col-form-label">パスワード（確認用）</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                    @if ($errors->has('password_confirmation'))
                        <div class="mt-2 text-danger">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>
            </div>
            
            <div class="card-footer bg-mycolor3 text-mycolor1">
                <div class="form-group d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger btn-mycolor1">保存</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
