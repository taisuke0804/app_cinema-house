<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CINEMA-HOUSE ユーザートップページ</title>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
  <!-- ヘッダー -->
  <nav class="navbar navbar-expand-lg bg-secondary navbar-dark">
    <div class="container-fluid">
      <!-- サイトタイトル -->
      <a class="navbar-brand text-white" href="/">CINEMA-HOUSE</a>

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
              ようこそ、<strong>ユーザー名</strong>さん
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

  <!-- トップページコンテンツ -->
  <div class="container mt-5">
    <h1 class="text-center">cinema-house ユーザートップページ</h1>
    <p class="text-center text-muted">
      ここにお好きな映画のリストやおすすめ情報を表示できます。
    </p>
    <div class="row">
      <!-- 映画一覧や他のコンテンツ -->
      <div class="col-md-4">
        <div class="card">
          <img src="movie1.jpg" class="card-img-top" alt="Movie 1">
          <div class="card-body">
            <h5 class="card-title">映画タイトル 1</h5>
            <p class="card-text">映画の概要がここに表示されます。</p>
            <a href="/movie-detail/1" class="btn btn-primary">詳細を見る</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img src="movie2.jpg" class="card-img-top" alt="Movie 2">
          <div class="card-body">
            <h5 class="card-title">映画タイトル 2</h5>
            <p class="card-text">映画の概要がここに表示されます。</p>
            <a href="/movie-detail/2" class="btn btn-primary">詳細を見る</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img src="movie3.jpg" class="card-img-top" alt="Movie 3">
          <div class="card-body">
            <h5 class="card-title">映画タイトル 3</h5>
            <p class="card-text">映画の概要がここに表示されます。</p>
            <a href="/movie-detail/3" class="btn btn-primary">詳細を見る</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /トップページコンテンツ -->
</body>
</html>
