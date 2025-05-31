<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
  <title>ユーザートップページ | CINEMA-HOUSE</title>
  @vite(['resources/css/style.css'])
</head>
<body>
  <nav class="header">
    <div class="header-left">
      <a class="header-title" href="/home">CINEMA-HOUSE</a>
      <div class="nav-links">
        <a class="header-link" href="{{ route('user.screenings.calendar.index') }}">上映スケジュール</a>
        <a class="header-link" href="{{ route('user.seat.reserve-list')}}">座席予約一覧</a>
      </div>
    </div>

    <div class="header-right">
      <span class="user-disp">ようこそ、<strong>{{ Auth::user()->name }}</strong>さん</span>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout">ログアウト</button>
      </form>
    </div>
  </nav>

  <main>
    @yield('content')
  </main>
</body>
</html>