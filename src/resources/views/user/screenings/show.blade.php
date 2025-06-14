@extends('layouts.user')

@section('title', 'ユーザートップページ | CINEMA-HOUSE')

@push('styles')
@vite(['resources/css/screenings.css', 'resources/js/screenings.js'])
@endpush

@section('content')

<section class="sc-section">
  <h4>上映スケジュール詳細</h4>

  <div class="sc-show">
    <h5 class="sc-title"><strong>映画タイトル:</strong> 『 {{ $screening->movie->title }} 』</h5>
    <p class="sc-info">
      <strong>ジャンル:</strong> {{ $screening->movie->genre->getLabel() }}<br>
      <strong>上映日:</strong> {{ $screening->start_time->format('Y年m月d日') }}<br>
      <strong>上映開始時刻:</strong> {{ $screening->start_time->format('H:i') }}<br>
      <strong>上映終了時刻:</strong> {{ $screening->end_time->format('H:i') }}
    </p>

    <hr>
    @if ($screening->start_time->isPast())
      <div class="caution-state">
        この上映スケジュールは終了しました。
      </div>
    @else
      <!-- ユーザーが予約済みの場合の警告 -->
      @if ($authReservedSeatInfo)
      <div class="info-state">
        <p>あなたの予約済み座席: {{ $authReservedSeatInfo->row }}{{ $authReservedSeatInfo->number }}</p>
      </div>
      @endif
      <!-- バリデーションエラーの表示 -->
      @if ($errors->any())
        <div class="error-state">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <h5 class="seat-info">座席予約状況</h5>
      <p class="reserve-kinds">緑色: 空き / 灰色: 他人の予約 / 黄色: 自分の予約 / 青色: 選択中</p>

      @foreach ($seatRows as $row => $seats)
        <div class="seat-row">
          <span class="row-label">{{ $row }}</span>
          <div class="seats">
            @foreach ($seats as $seat)
              <button @class(['seat', 
                'seat-not-reserve' => !$seat->is_reserved, 
                'seat-reserve' => $seat->is_reserved,
                'auth-reserve' => $seat->auth_reserved])
                data-seat-id="{{ $seat->id }}"
                data-row="{{ $row }}"
                data-number="{{ $seat->number }}"
                @disabled($seat->auth_exists)
              >
                {{ $row }}{{ $seat->number }}
              </button>
            @endforeach
          </div>
        </div>
      @endforeach

      @if (!$authReservedSeatInfo)
        <hr>
        <h5 class="seat-info">選択した座席情報</h5>
        <p class="reserve-state" id="select-seat">座席が選択されていません。</p>

        <button class="reserve-button" id="reserve-btn" disabled>予約する</button>

        <!-- モーダル -->
        <div id="modalOverlay" class="modal-overlay">
          <div class="modal-content">
            <form method="POST" action="{{ route('user.seat.reserve', ['screening_id' => $screening->id]) }}">
            @csrf
              <div class="modal-header">
                <h3>座席予約確認</h3>
                <span class="modal-close" id="closeModalBtn">&times;</span>
              </div>
              <div class="modal-body">
                <p id="modalSeatInfo">選択した座席: なし</p>
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="row" id="modal-row">
                <input type="hidden" name="number" id="modal-number">
              </div>
              <div class="modal-footer">
                <button class="btn cancel-btn" id="cancelBtn" type="button">キャンセル</button>
                <button class="btn confirm-btn" type="submit">予約する</button>
              </div>
            </form>
          </div>
        </div>
      @endif
    @endif

  </div>
</section>

@endsection