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
      <tr>
        <td class="text-wrap" style="max-width: 400px;">とても長い映画タイトルがここに入ります。タイトルが長くても折り返して全体を表示します。</td>
        <td>2023-01-01</td>
        <td class="text-truncate" style="max-width: 300px;">
          ハリー・ポッターは、魔法使いの世界で有名な一家の子供である。彼は、両親が魔法使いの世界で殺された後、叔父夫婦のもとで育てられていた。しかし、11歳の誕生日に、ホグワーツ魔法学校に入学することができることがわかり、そこで新しい友達と出会い、新しい世界を知る。
        </td>
        <td><a href="/admin/movies/detail.html?id=1" class="btn btn-primary btn-sm">詳細</a></td>
      </tr>
      <tr>
        <td class="text-wrap" style="max-width: 400px;">短いタイトル</td>
        <td>2023-02-01</td>
        <td class="text-truncate" style="max-width: 300px;">
          ハリー・ポッターは、ホグワーツ魔法学校での2年目を迎える。しかし、学校には謎の怪物が現れ、生徒たちが次々と石になってしまう事件が起こる。ハリーは、この事件の真相を解明するために、秘密の部屋に潜入する。</td>
        <td><a href="/admin/movies/detail.html?id=2" class="btn btn-primary btn-sm">詳細</a></td>
      </tr>
    </tbody>
  </table>

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
</div>
@endsection