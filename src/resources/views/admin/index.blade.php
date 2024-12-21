<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者トップ | CINEMA-HOUSE </title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
  <!-- 管理者トップページ用のヘッダー -->
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <!-- サイト名と管理者トップ -->
      <a class="navbar-brand d-flex align-items-center" href="/admin/index.html">
        <span class="me-3">CINEMA-HOUSE</span>
        <span>管理者TOP</span>
      </a>

      <!-- ヘッダーの右側部分 -->
      <ul class="navbar-nav d-flex flex-row align-items-center">
        <!-- 管理者の名前表示 -->
        <li class="nav-item me-3">
          <span class="navbar-text text-light">管理者: 山田 太郎</span>
        </li>
        <!-- ログアウトボタン -->
        <li class="nav-item">
          <a href="{{ route('admin.logout') }}" class="btn btn-outline-light btn-sm" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            ログアウト
          </a>
          <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /管理者トップページのヘッダー -->

  <!-- Bootstrap JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
