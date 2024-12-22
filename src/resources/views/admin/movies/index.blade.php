@extends('layouts.admin')

@section('title', '映画一覧 | CINEMA-HOUSE')

@section('content')
<div class="container mt-4">
  <h1 class="mb-4">映画一覧</h1>
  <table class="table table-striped">
    <thead>
      <tr>
        <th class="col-4" style="width: 400px;">タイトル</th>
        <th>公開日</th>
        <th>説明文</th>
        <th>詳細</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($movies as $movie)
      <tr>
        <td class="text-wrap" style="max-width: 400px;">{{ $movie->title }}</td>
        <td>{{ $movie->release_date }}</td>
        <td class="text-truncate" style="max-width: 300px;">{{ $movie->description }}</td>
        <td><a href="#" class="btn btn-primary btn-sm">詳細</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- ページネーションリンク --}}
  {{ $movies->links() }}

  {{--
  <!-- ページネーション -->
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
  --}}
  
</div>
@endsection