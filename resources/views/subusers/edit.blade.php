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
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('mypage.index') }}">マイページ</a></li>
            <li class="breadcrumb-item active" aria-current="page">サブユーザー情報変更</li>
        </ol>
    </nav>

    <div class="card mt-3">
        @if ($subUser->user_image_path)                            
            <img src="{{ $subUser->user_image_path ? $subUser->user_image_path : asset('images/default-avatar.png') }}" class="card-img-top" alt="{{ $subUser->nickname }}">
            {{-- <img src="{{ asset('storage/' . $subUser->user_image_path) }}" alt="{{ $subUser->nickname }}" class="card-img-top custom-card-img"> --}}
        @endif

        <div class="card-body">
            <form action="{{ route('subusers.update', $subUser->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- ニックネーム -->
                <div class="form-group">
                    <label for="nickname" class="col-form-label">ニックネーム</label>
                    <input type="text" class="form-control" id="nickname" name="nickname" value="{{ old('nickname', $subUser->nickname) }}" required autofocus autocomplete="nickname">
                    @if ($errors->has('nickname'))
                        <div class="mt-2 text-danger">{{ $errors->first('nickname') }}</div>
                    @endif
                </div>

                <!-- 画像 -->
                <div class="form-group mt-2">
                    <label for="user_image_path" class="col-form-label">画像</label>
                    <input type="file" class="form-control" id="user_image_path" name="user_image_path">
                    @if ($errors->has('user_image_path'))
                        <div class="alert alert-danger mt-2">{{ $errors->first('user_image_path') }}</div>
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
    
    {{-- サブユーザーの削除用モーダル --}}
    @include('modals.subuser-delete-modal')

    {{-- 削除フォーム --}}
    <button class="btn btn-outline-danger delete-button float-end mt-3" data-bs-toggle="modal" data-bs-target="#deleteSubuserModal">ユーザー削除</button>
</div>
@endsection
