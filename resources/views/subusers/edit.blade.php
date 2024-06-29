@extends('layouts.app')

@section('content')
<div class="container">
    <h1>サブユーザー編集</h1>
    <form action="{{ route('subusers.update', $subUser->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nickname">ニックネーム</label>
            <input type="text" class="form-control" id="nickname" name="nickname" value="{{ $subUser->nickname }}" required>
        </div>
        <div class="form-group">
            <label for="user_image_path">画像</label>
            <input type="file" class="form-control" id="user_image_path" name="user_image_path">
            @if ($errors->has('user_image_path'))
                <div class="alert alert-danger mt-2">{{ $errors->first('user_image_path') }}</div>
            @endif
            @if ($subUser->user_image_path)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $subUser->user_image_path) }}" alt="{{ $subUser->nickname }}" style="max-width: 200px;">
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary mt-3">保存</button>
    </form>

    {{-- 削除フォーム --}}
    <form action="{{ route('subusers.destroy', $subUser->id )}}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger">削除</button>
    </form>
</div>
@endsection
