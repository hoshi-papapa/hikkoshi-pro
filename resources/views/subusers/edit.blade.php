@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: 1.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('mypage.index') }}">マイページ</a></li>
            <li class="breadcrumb-item active" aria-current="page">サブユーザー情報変更</li>
        </ol>
    </nav>

    <div class="card mt-3">
        @if ($subUser->user_image_path)
            <img src="{{ asset('storage/' . $subUser->user_image_path) }}" alt="{{ $subUser->nickname }}" class="card-img-top custom-card-img">
        @endif

        <div class="card-body">
            <form action="{{ route('subusers.update', $subUser->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- ニックネーム -->
                <div class="form-group row">
                    <label for="planned_moving_date" class="col-sm-2 col-form-label">ニックネーム</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nickname" name="nickname" value="{{ old('nickname', $subUser->nickname) }}" required autofocus autocomplete="nickname">
                        @if ($errors->has('nickname'))
                            <div class="mt-2 text-danger">{{ $errors->first('nickname') }}</div>
                        @endif
                    </div>
                </div>

                {{-- 画像 --}}
                <div class="form-group row mt-4">
                    <label for="user_image_path" class="col-sm-2 col-form-label">画像</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="user_image_path" name="user_image_path">
                        @if ($errors->has('user_image_path'))
                            <div class="alert alert-danger mt-2">{{ $errors->first('user_image_path') }}</div>
                        @endif
                    </div>
                </div>
        </div>

        <div class="card-footer bg-mycolor3 text-mycolor1">
            <div class="form-group d-flex justify-content-center">
                <button type="submit" class="btn btn-danger btn-mycolor1">保存</button>
            </div>
            </form>
        </div>
    </div>
    
    {{-- 削除フォーム --}}
    <form action="{{ route('subusers.destroy', $subUser->id )}}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger float-end">ユーザー削除</button>
    </form>

</div>
@endsection
