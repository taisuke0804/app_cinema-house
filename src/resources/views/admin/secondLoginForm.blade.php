<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者2段階認証・ワンタイムパス入力 | CINEMA-HOUSE</title>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white text-center">
            <h5>ワンタイムパスワード入力</h5>
          </div>
          <div class="card-body">
            <!-- バリデーションメッセージ -->
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <!-- ワンタイムパスワード入力フォーム -->
            <form method="POST" action="{{ route('admin.secondAuth')}}">
              @csrf
              <input type="hidden" name="email" value="{{ request()->email }}">
              <div class="mb-3">
                <label for="tfa_token" class="form-label">ワンタイムパスワード</label>
                <input 
                  type="number" 
                  id="tfa_token" 
                  name="tfa_token" 
                  class="form-control @error('tfa_token') is-invalid @enderror" 
                  placeholder="4桁のパスワードを入力" 
                  required>
                @error('tfa_token')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">認証する</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
