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
      <!-- サイトタイトル -->
      <a class="navbar-brand text-white" href="/home">CINEMA-HOUSE</a>
      <a class="nav-link text-white ms-3" href="{{ route('user.screenings.calendar.index') }}">
        上映スケジュール
      </a>
      <a class="nav-link text-white ms-3" href="{{ route('user.seat.reserve-list')}}">
        座席予約一覧
      </a>

      <!-- トグルボタン（レスポンシブ対応） -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- ユーザー情報とログアウトボタン -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <span class="navbar-text text-white me-3">
              <!-- ログインしたユーザー名を表示 -->
              ようこそ、<strong>{{ Auth::user()->name }}</strong>さん
            </span>
          </li>
          <li class="nav-item">
            <!-- <a class="btn btn-outline-light" href="/logout">ログアウト</a> -->
            <a class="btn btn-outline-light" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              ログアウト
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- /ヘッダー -->

  <main class="container mt-4 mb-5">
    @yield('content')
  </main>

</body>
</html>