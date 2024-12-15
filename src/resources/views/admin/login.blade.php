<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者ログイン画面 | CINEMA-HOUSE</title>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
  
  <!-- 管理者ログインフォーム -->
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header text-center bg-info-subtle text-dark">
            <h4>管理者ログイン</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="index.html">
              @csrf
              <!-- メールアドレス -->
              <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control border-info" id="email" name="email" placeholder="メールアドレスを入力">
              </div>
              <!-- パスワード -->
              <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control border-info" id="password" name="password" placeholder="パスワードを入力">
              </div>
              <!-- 送信ボタン -->
              <div class="d-grid">
                <button type="submit" class="btn btn-info text-white">ログイン</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /管理者ログインフォーム -->
</body>
</html>
