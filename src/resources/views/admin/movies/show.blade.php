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

  {{-- 戻るボタン --}}
  <div class="mt-4">
    <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">映画一覧に戻る</a>
  </div>
</div>
@endsection
