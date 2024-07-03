<!-- resources/views/layouts/style.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Your custom styles -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!-- Font Awesome CSS (for icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        /* Custom CSS for Navbar */
        .navbar {
            background-color: #222;
            padding: 0.5rem 1rem;
        }
        .navbar-brand {
            color: #f8f9fa !important;
            font-weight: bold;
            font-size: 1.25rem;
        }
        .navbar-nav .nav-link {
            color: #f8f9fa !important;
            font-weight: bold;
            font-size: 1rem;
            margin-right: 0.5rem;
            margin-left: 0.5rem;
        }
        .navbar-nav .nav-link:hover {
            color: #17a2b8 !important;
        }
        .navbar-toggler {
            border-color: #17a2b8;
            padding: 0.25rem 0.5rem;
        }
        .navbar-toggler-icon {
            background-color: #f8f9fa;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">Kantin Online</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('cart') }}">Keranjang</a>
        </li>
        <!-- Tambahkan item lainnya sesuai kebutuhan -->
      </ul>
      <ul class="navbar-nav ms-auto">
        <!-- Authentication Links -->
        @guest
          @if (Route::has('login'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
          @endif
          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
          @endif
        @else
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="fas fa-user"></i> {{ Auth::user()->name }}
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

@yield('content')

<!-- Bootstrap Bundle with Popper -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
