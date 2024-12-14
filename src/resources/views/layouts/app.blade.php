<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
  <!-- ヘッダー -->
  <nav class="navbar navbar-expand-lg bg-secondary navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand text-white" href="{{ route('index') }}">CINEMA-HOUSE</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <a class="btn btn-outline-light" href="{{ route('login') }}">ログイン</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- /ヘッダー -->

  <main>
    @yield('content')
  </main>

</body>
</html>