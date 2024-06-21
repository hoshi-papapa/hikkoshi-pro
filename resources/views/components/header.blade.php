<nav class="navbar navbar-expand-md navbar-light bg-warning shadow-sm mb-3">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/stores') }}">
            <img src="{{ asset('img/logo.jpg') }}" style="height: 40px; ">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-3 text-dark">
                    <a href="{{route('favorite.index') }}" class="text-dark">
                        <i class="fa-solid fa-heart"></i>
                    </a>
                </li>
                <li class="nav-item me-3">
                    <a href="{{route('reservation.index') }}" class="text-dark">
                        <i class="fa-solid fa-calendar"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('mypage') }}" class="fw-bold text-dark" style="text-decoration: none;">
                        マイページ
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>