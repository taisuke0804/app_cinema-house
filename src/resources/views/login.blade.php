<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ Vite::asset('resources/images/favicon.png') }}">
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
  <title>ログイン | CINEMA-HOUSE</title>
  @vite(['resources/css/style.css'])
</head>
<body>
  <main class="bg-image">
    <div class="container login-container">
      <h1 class="site-title">
        <a href="{{ route('index')}}">
          CINEMA-HOUSE
        </a>
      </h1>

      <p>CINEMA-HOUSEのアカウントにログイン</p>

      <!-- バリデーションエラーの表示 -->
      @if ($errors->any())
      <div class="alert">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <!-- /バリデーションエラーの表示 -->

      <form method="POST" class="login-form" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
          <label class="form-label" for="email">メールアドレス</label>
          <input class="form-input @error('password') invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力">
          @error('email')
            <div class="invalid-message">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="password">パスワード</label>
          <input class="form-input @error('password') invalid @enderror" id="password" type="password" name="password" value="{{ old('password') }}" placeholder="パスワードを入力">
          @error('password')
            <div class="invalid-message">{{ $message }}</div>
          @enderror
        </div>
        <div>
          <button class="login-btn" type="submit">ログイン</button>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
