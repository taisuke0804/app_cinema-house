@extends('layouts.app')

@section('title', 'ユーザートップページ | CINEMA-HOUSE')

@section('content')
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
@endsection