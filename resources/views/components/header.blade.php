<header class="navbar navbar-expand-sm shadow-sm bg-mycolor2">
    <div class="container" style="max-width: 800px;">
        <a class="navbar-brand" href="{{ url('/tasks') }}">
            <img src="{{ asset('images/logo.png') }}" style="height: 40px; ">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-2">
                    <a href="{{route('tasks.index') }}" class="fw-bold text-mycolor1" style="text-decoration: none;">
                        やることリスト
                    </a>
                </li>
                
                <li class="nav-item me-2 align-self-center separator">|</li> <!-- 区切り文字 -->

                <li class="nav-item me-2">
                    <a href="{{route('mypage.index') }}" class="fw-bold text-mycolor1" style="text-decoration: none;">
                        マイページ
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>