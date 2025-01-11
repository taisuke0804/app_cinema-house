@extends('layouts.admin')

@section('title', '映画詳細 | CINEMA-HOUSE')

@section('content')
<div class="container mt-4 position-relative">
  <h1 class="mb-4">映画詳細</h1>

  {{-- 削除ボタン --}}
  <button type="button" class="btn btn-danger btn-m position-absolute top-0 end-0 mt-2 me-3" data-bs-toggle="modal" data-bs-target="#deleteMovieModal">
    削除
  </button>

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

{{-- 削除確認モーダル --}}
<div class="modal fade" id="deleteMovieModal" tabindex="-1" aria-labelledby="deleteMovieModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteMovieModalLabel">映画削除確認</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
      </div>
      <div class="modal-body">
        紐づいている上映スケジュール、座席予約情報も全て削除されます。よろしいですか？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        <form action="#" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">削除する</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
