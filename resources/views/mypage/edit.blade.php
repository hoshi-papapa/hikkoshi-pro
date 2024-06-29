@extends('layouts.app')

@section('content')
<div class="container">
    <h1>ユーザー情報変更</h1>
    <form action="{{ route('mypage.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @if ($errors->has('name'))
                <div class="mt-2 text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <!-- 引越予定日 -->
        <div class="form-group mt-4">
            <label for="planned_moving_date">引越予定日</label>
            <input type="date" class="form-control" id="planned_moving_date" name="planned_moving_date" value="{{ old('planned_moving_date', $user->planned_moving_date) }}" required autofocus autocomplete="planned_moving_date">
            @if ($errors->has('planned_moving_date'))
                <div class="mt-2 text-danger">{{ $errors->first('planned_moving_date') }}</div>
            @endif
        </div>

        <!-- 電話番号 -->
        <div class="form-group mt-4">
            <label for="phone_number">電話番号</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required autofocus autocomplete="phone_number">
            @if ($errors->has('phone_number'))
                <div class="mt-2 text-danger">{{ $errors->first('phone_number') }}</div>
            @endif
        </div>

        <!-- Email Address -->
        <div class="form-group mt-4">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @if ($errors->has('email'))
                <div class="mt-2 text-danger">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <!-- Password -->
        <div class="form-group mt-4">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
            @if ($errors->has('password'))
                <div class="mt-2 text-danger">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <!-- Confirm Password -->
        <div class="form-group mt-4">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
            @if ($errors->has('password_confirmation'))
                <div class="mt-2 text-danger">{{ $errors->first('password_confirmation') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">保存</button>
    </form>
</div>
@endsection