@extends('layouts.app')

@section('content')
<div class="container">
    <h1>サブユーザー追加</h1>
    <form action="{{ route('subusers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="nickname">ニックネーム</label>
            <input type="text" class="form-control" id="nickname" name="nickname" value="{{ old('nickname') }}">
        </div>
        
        <div class="form-group">
            <label for="user_image_path">ユーザー画像</label>
            <input type="file" class="form-control" id="user_image_path" name="user_image_path">
            @if ($errors->has('user_image_path'))
                <div class="alert alert-danger mt-2">{{ $errors->first('user_image_path') }}</div>
            @endif
        </div>
        
        <button type="submit" class="btn btn-primary">作成</button>
    </form>
</div>
@endsection
