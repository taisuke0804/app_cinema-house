@extends('layouts.admin')

@section('title', '映画一覧 | CINEMA-HOUSE')

@section('content')
<div class="container mt-4">
  {{-- フラッシュメッセージ --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="閉じる"></button>
    </div>
  @endif

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">映画一覧</h1>
    {{-- 映画新規登録ボタン --}}
    <a href="{{ route('admin.movies.create') }}" class="btn btn-success">映画を新規登録</a>
  </div>

  {{-- 検索フォーム --}}
  <div class="accordion mb-4" id="searchAccordion">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingSearch">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#searchForm" aria-expanded="false" aria-controls="searchForm">
          検索条件を表示
        </button>
      </h2>
      <div id="searchForm" 
        class="accordion-collapse collapse {{ request()->hasAny(['title', 'genre', 'description']) ? 'show' : '' }}" 
        aria-labelledby="headingSearch" data-bs-parent="#searchAccordion">
        <div class="accordion-body">
          <form method="GET" action="{{ route('admin.movies.index') }}">
            <div class="row g-3">
              {{-- タイトル検索 --}}
              <div class="col-md-6">
                <label for="title" class="form-label">タイトル</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ request('title') }}">
              </div>

              {{-- 完全一致・あいまい検索 --}}
              <div class="col-md-6">
                  <label class="form-label">タイトル検索方法</label>
                  <div class="d-flex align-items-center">
                      {{-- あいまい検索 --}}
                      <div class="form-check me-3">
                          <input class="form-check-input" type="radio" name="search_type" id="partial" value="partial" 
                              {{ request('search_type', 'partial') == 'partial' ? 'checked' : '' }}>
                          <label class="form-check-label" for="partial">あいまい</label>
                      </div>
                      {{-- 完全一致 --}}
                      <div class="form-check">
                          <input class="form-check-input" type="radio" name="search_type" id="exact" value="exact" 
                              {{ request('search_type') == 'exact' ? 'checked' : '' }}>
                          <label class="form-check-label" for="exact">完全一致</label>
                      </div>
                  </div>
              </div>

              {{-- ジャンル検索（空の状態） --}}
              <div class="col-md-6">
                <label for="genre" class="form-label">ジャンル</label>
                <select class="form-select" id="genre" name="genre">
                  <option value="">すべて</option>
                  @foreach (\App\Enums\Genre::cases() as $genre)
                    <option value="{{ $genre->value }}" {{ request('genre') == $genre->value ? 'selected' : '' }}>
                      {{ $genre->getLabel() }}
                    </option>
                  @endforeach
                </select>
              </div>

              {{-- 説明文検索 --}}
              <div class="col-md-6">
                <label for="description" class="form-label">説明文</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ request('description') }}">
              </div>
            </div>
            <div class="mt-3 text-end">
              <button type="submit" class="btn btn-primary">検索</button>
              <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">リセット</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- 映画一覧テーブル --}}
  <table class="table table-striped">
    <thead>
      <tr>
        <th class="col-4" style="width: 400px;">タイトル</th>
        <th>ジャンル</th>
        <th>説明文</th>
        <th>詳細</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($movies as $movie)
      <tr>
        <td class="text-wrap" style="max-width: 400px;">{{ $movie->title }}</td>
        <td>{{ $movie->genre->getLabel() }}</td>
        <td class="text-truncate" style="max-width: 300px;">{{ $movie->description }}</td>
        <td><a href="{{ route('admin.movies.show', $movie->id) }}" class="btn btn-primary btn-sm">詳細</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- ページネーションリンク --}}
  {{ $movies->links('vendor.pagination.movie') }}
</div>

@endsection
