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
            <li class="breadcrumb-item active" aria-current="page">サブユーザー追加</li>
        </ol>
    </nav>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('subusers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- ニックネーム -->
                <div class="form-group row">
                    <label for="planned_moving_date" class="col-sm-2 col-form-label">ニックネーム</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nickname" name="nickname" value="{{ old('nickname') }}" required autofocus autocomplete="nickname">
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
                <button type="submit" class="btn btn-danger btn-mycolor1">作成</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
