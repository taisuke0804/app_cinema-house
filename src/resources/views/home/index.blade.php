@extends('layouts.app')

@section('title', 'ユーザートップページ | CINEMA-HOUSE')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4">座席予約一覧</h2>
  @if($reservations->isEmpty())
  <div class="alert alert-info">
    現在、予約されている座席はありません。
  </div>
  @else
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>映画タイトル</th>
        <th>上映日</th>
        <th>上映時間</th>
        <th>座席番号</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      @foreach($reservations as $reservation)
      <tr>
        <td>{{ $reservation->screening->movie->title }}</td>
        <td>{{ $reservation->screening->start_time->format('Y年m月d日') }}</td>
        <td>{{ $reservation->screening->start_time->format('H:i') }} ～ {{ $reservation->screening->end_time->format('H:i') }}</td>
        <td>{{ $reservation->row .  strval($reservation->number) }}</td>
        <td>
          <form action="" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="alert('キャンセル処理は未実装です')">
              キャンセル
            </button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endif
</div>
@endsection