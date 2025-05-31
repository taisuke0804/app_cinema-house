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
  <title>CINEMA-HOUSE</title>
  @vite(['resources/css/style.css'])
</head>
<body>
  <main class="bg-image">
    <div class="container top-container">
      <h1 class="site-title">
        <a href="{{ route('index')}}">
          CINEMA-HOUSE
        </a>
      </h1>
      <p>ようこそ、映画の世界へ</p>
      <a class="btn" href="{{ route('login')}}">ログインページへ</a>
    </div>
  </main>
</body>
</html>