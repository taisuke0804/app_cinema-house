@extends('layouts.admin')

@section('title', '映画詳細 | CINEMA-HOUSE')

@section('content')
<div class="container mt-4">
  <h1 class="mb-4">映画詳細</h1>

  {{-- 詳細情報 --}}
  <div class="card">
    <div class="card-header">
      映画情報
    </div>
    <div class="card-body">
      <h5 class="card-title">タイトル: <span class="fw-bold">『 {{ $movie->title }} 』</span></h5>
      <p class="card-text">ジャンル: <span class="fw-bold">{{ $movie->genre->getLabel() }}</span></p>
      <p class="card-text">説明文:</p>
      <p class="card-text">{{ $movie->description }}</p>
    </div>
  </div>

  {{-- アクションボタン --}}
  <div class="mt-4 d-flex justify-content-between">
    {{-- 戻るボタン --}}
    <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">映画一覧に戻る</a>
    
    {{-- 上映スケジュール新規登録ボタン --}}
    <a href="{{ route('admin.screenings.create', $movie->id) }}" class="btn btn-primary">上映スケジュールを登録</a>
  </div>
</div>
@endsection
