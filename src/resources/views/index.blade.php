<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CINEMA-HOUSE</title>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
  <div class="container mt-5">
    <!-- タイトル -->
    <div class="text-center mb-4">
      <h1 class="display-4">CINEMA-HOUSE</h1>
      <p class="lead">ようこそ、映画の世界へ</p>
    </div>
    <!-- /タイトル -->

    <!-- ログインページに遷移するボタン -->
    <div class="d-flex justify-content-center">
      <a href="{{ route('login') }}" class="btn btn-primary btn-lg">ログインページへ</a>
    </div>
    <!-- /ログインページに遷移するボタン -->
  </div>
</body>
</html>