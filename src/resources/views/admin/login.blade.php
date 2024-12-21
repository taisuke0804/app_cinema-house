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

            <form method="POST" action="{{ route('admin.login.post') }}">
              @csrf
              <!-- メールアドレス -->
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
              <!-- パスワード -->
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
