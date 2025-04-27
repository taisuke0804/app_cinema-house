@extends('layouts.user')

@section('title', 'ユーザートップページ | CINEMA-HOUSE')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4 text-center">ユーザートップページ</h2>

  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
      <h5 class="card-title mb-0">アプリの概要</h5>
    </div>
    <div class="card-body">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">■ プライベートシネマの座席予約アプリ</li>
        <li class="list-group-item">■ 上映スケジュールページから日付・作品を選び予約する</li>
        <li class="list-group-item">■ 予約した内容は座席予約一覧ページから確認</li>
      </ul>
    </div>
  </div>
</div>
@endsection
