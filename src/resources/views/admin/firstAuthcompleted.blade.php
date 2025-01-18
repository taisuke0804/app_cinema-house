<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者2段階認証・メール送信完了 | CINEMA-HOUSE</title>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white text-center">
            <h5>メール送信完了</h5>
          </div>
          <div class="card-body text-center">
            <p class="mb-4">
              管理者メールアドレスにワンタイムパスワードを送信しましたのでご確認ください。
            </p>
            <a href="{{ route('admin.login') }}" class="btn btn-primary">管理者ログインに戻る</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
