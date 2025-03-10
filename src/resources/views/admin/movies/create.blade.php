@extends('layouts.admin')

@section('title', '映画新規登録 | CINEMA-HOUSE')

@section('content')
<div class="container mt-4">
  <h1 class="mb-4">映画新規登録</h1>

  {{-- バリデーションエラーメッセージ --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form id="movie-form" method="POST" action="{{ route('admin.movies.store') }}">
    @csrf
    <div class="mb-3">
      <label for="title" class="form-label">映画タイトル</label>
      <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
    </div>

    <div class="mb-3">
      <label for="genre" class="form-label">ジャンル</label>
      <select class="form-select" id="genre" name="genre" required>
        <option value="" disabled selected>ジャンルを選択</option>
        {{-- \App\Enums\Genre::cases() を利用 --}}
        @foreach (\App\Enums\Genre::cases() as $genre)
          <option value="{{ $genre->value }}" {{ old('genre') == $genre->value ? 'selected' : '' }}>
            {{ $genre->getLabel() }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">説明文</label>
      {{-- 高さを固定した説明文欄 --}}
      <textarea class="form-control" id="description" name="description" style="height: 150px;" required>{{ old('description') }}</textarea>
    </div>

    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">登録</button>
    </div>
  </form>
</div>

{{-- 確認用モーダルの呼び出し --}}
<x-modal id="confirmModal" title="登録確認">
  @slot('body', '入力内容を送信してよろしいですか？')

  @slot('footer')
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
    <button type="button" class="btn btn-primary" onclick="document.getElementById('movie-form').submit();">送信</button>
  @endslot
</x-modal>

@endsection