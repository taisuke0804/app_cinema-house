@extends('layouts.admin')

@section('title', '映画一覧 | CINEMA-HOUSE')

@section('content')
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">映画一覧</h1>
    {{-- 映画新規登録ボタン --}}
    <a href="{{ route('admin.movies.create') }}" class="btn btn-success">映画を新規登録</a>
  </div>

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
        <td><a href="#" class="btn btn-primary btn-sm">詳細</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- ページネーションリンク --}}
  {{ $movies->links('vendor.pagination.movie') }}
</div>
@endsection