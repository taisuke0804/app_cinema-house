<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
  <title>@yield('title', '管理画面')</title>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  @stack('scripts')
  @stack('styles')
</head>

<body>
  <!-- ヘッダー部分 -->
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- サイト名とリンク -->
        <div class="d-flex align-items-center">
            <a class="navbar-brand me-4" href="{{ route('admin.index') }}">
                <span>CINEMA-HOUSE</span>
                <span>管理者TOP</span>
            </a>
            <!-- 映画一覧リンク -->
            <a href="{{ route('admin.movies.index') }}" class="nav-link text-light ms-4">
              映画一覧
            </a>
            <!-- 上映カレンダー -->
            <a href="{{ route('admin.screenings.calendar.index') }}" class="nav-link text-light ms-4">
              上映カレンダー
            </a>
            <!-- ユーザー管理画面 -->
            <a href="{{ route('admin.users.index') }}" class="nav-link text-light ms-4">
              ユーザー管理
            </a>
        </div>

        <!-- ヘッダーの右側部分 -->
        <ul class="navbar-nav d-flex flex-row align-items-center">
            <!-- 管理者の名前表示 -->
            <li class="nav-item me-3">
                <span class="navbar-text text-light">管理者: {{ Auth::user()->name }}</span>
            </li>
            <!-- ログアウトボタン -->
            <li class="nav-item">
                <a href="{{ route('admin.logout') }}" class="btn btn-outline-light btn-sm"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    ログアウト
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>

  <!-- コンテンツ部分 -->
  <main class="container mt-4 mb-5">
    @yield('content')
  </main>

</body>

</html>