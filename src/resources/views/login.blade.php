<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン | CINEMA-HOUSE</title>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
  <div class="container mt-5">
    <!-- タイトル -->
    <div class="text-center mb-4">
      <a href="/" class="d-block mb-3 text-decoration-none text-primary fs-1">CINEMA-HOUSE</a>
      <h1 class="h3">ログイン</h1>
      <p class="lead">CINEMA-HOUSEのアカウントにログイン</p>
    </div>
    <!-- /タイトル -->

    <!-- ログインフォーム -->
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <!-- バリデーションエラーの表示 -->
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <!-- /バリデーションエラーの表示 -->

            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input 
                  type="email" 
                  class="form-control @error('email') is-invalid @enderror" 
                  id="email" 
                  name="email" 
                  value="{{ old('email') }}" 
                  placeholder="メールアドレスを入力">
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input 
                  type="password" 
                  class="form-control @error('password') is-invalid @enderror" 
                  id="password" 
                  name="password" 
                  placeholder="パスワードを入力">
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">ログイン</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /ログインフォーム -->
  </div>
</body>
</html>
