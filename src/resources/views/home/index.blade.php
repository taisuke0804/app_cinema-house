@extends('layouts.app')

@section('title', 'ユーザートップページ | CINEMA-HOUSE')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4">座席予約一覧</h2>

  {{-- 処理完了のメッセージ表示 --}}
  @if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
  @endif

  {{-- バリデーションエラーメッセージの表示 --}}
  @if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  
  {{-- 予約がない場合のメッセージ表示 --}}
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
          <form action="{{ route('user.seat.cancel') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="seat_id" value="{{ $reservation->id }}">
            <input type="hidden" name="screening_id" value="{{ $reservation->screening->id }}">
            <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}">
            <input type="hidden" name="row" value="{{ $reservation->row }}">
            <input type="hidden" name="number" value="{{ $reservation->number }}">
            <button type="submit" class="btn btn-danger btn-sm" onclick="alert('予約をキャンセルしますか？');">
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