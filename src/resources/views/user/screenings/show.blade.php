@extends('layouts.app')

@section('title', '上映スケジュール詳細 | CINEMA-HOUSE')

@section('content')

<div class="card">
  <div class="card-header bg-primary text-white">
    上映スケジュール詳細
  </div>
  <div class="card-body">
    <h5 class="card-title fs-3">映画タイトル: 『 {{ $screening->movie->title }} 』</h5>
    <p class="card-text">
      <strong>ジャンル:</strong> {{ $screening->movie->genre->getLabel() }}<br>
      <strong>上映日:</strong> {{ $screening->start_time->format('Y年m月d日') }}<br>
      <strong>上映開始時刻:</strong> {{ $screening->start_time->format('H:i') }}<br>
      <strong>上映終了時刻:</strong> {{ $screening->end_time->format('H:i') }}
    </p>

    <!-- 過去の上映スケジュールの場合の警告 -->
    @if ($screening->start_time->isPast())
      <div class="alert alert-warning">
        この上映スケジュールは終了しました。
      </div>
    @else
    <!-- バリデーションエラーの表示 -->
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <!-- ユーザーが予約済みの場合の警告 -->
    @if ($authReservedSeatInfo)
    <div class="alert alert-info">
      <p>あなたの予約済み座席: {{ $authReservedSeatInfo->row }}{{ $authReservedSeatInfo->number }}</p>
    </div>
    @endif

    <!-- 席予約状況 -->
    <hr>
    <h5>座席予約状況</h5>
    <p class="text-muted">緑色: 空き / 灰色: 他人の予約 / 黄色: 自分の予約 / 青色: 選択中</p>
    <div class="d-flex flex-column align-items-start">

      @foreach ($seatRows as $row => $seats)
        <div class="d-flex align-items-center mb-2">
          <span class="me-2">{{ $row }}</span>
          <div class="d-flex">
            @foreach ($seats as $seat)
              @php
                $seatColor = $seat['is_reserved'] ? 'bg-secondary' : 'bg-success';
                $seatColor = $seat['auth_reserved'] ? 'bg-warning' : $seatColor;

                // Bootstrapのカスタムクラスを設定
                $clickable = (!$seat['is_reserved'] && !$authReservedSeatInfo) ? 'clickable' : 'not-allowed';
              @endphp
              <div class="seat {{ $seatColor}} {{ $clickable }} text-white me-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; font-size: 1rem; border-radius: 4px;"
                data-row="{{ $seat['row'] }}" data-number="{{ $seat['number'] }}" data-is-reserved="{{ $seat['is_reserved'] }}">
                {{ $seat['label'] }}
              </div>
            @endforeach
          </div>
        </div>
      @endforeach

      

      <!-- 選択した座席情報 -->
      <hr>
      <h5>選択した座席情報</h5>
      <p id="selected-seat" class="text-muted">座席が選択されていません。</p>

      <button id="reserve-button" class="btn btn-primary mt-3" disabled data-bs-toggle="modal"
        data-bs-target="#reserveModal">
        予約する
      </button>

      <!-- 予約確認モーダル -->
      <div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reserveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST" action="{{ route('user.seat.reserve', ['screening_id' => $screening->id]) }}">
              @csrf
              <div class="modal-header">
                <h5 class="modal-title" id="reserveModalLabel">座席予約確認</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p id="modal-selected-seat">選択した座席: なし</p>
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="row" id="modal-row">
                <input type="hidden" name="number" id="modal-number">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                <button type="submit" class="btn btn-primary">予約する</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /予約確認モーダル -->

    </div>
  </div>
  @endif

</div>

<!-- jQueryによる非同期処理 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@if (!$authReservedSeatInfo)
<script>
  $(document).ready(function () {
    // 空席（緑色）の座席がクリックされたときの処理
    $('.seat.bg-success').on('click', function () {
      const $seat = $(this);

      // 座席が選択済み（青色）の場合、その座席を選択解除
      if ($seat.hasClass('bg-primary')) {
        $seat.removeClass('bg-primary').addClass('bg-success'); // 空席（緑色）に戻す
        $('#selected-seat').text('座席が選択されていません。'); // 選択状態をリセット
        $('#reserve-button').prop('disabled', true); // 予約ボタンを無効化
      }
      // 空席（緑色）の座席が選択された場合
      else if ($seat.hasClass('bg-success')) {
        // 他の選択済み座席をリセット（単一選択にするため）
        $('.seat.bg-primary').removeClass('bg-primary').addClass('bg-success');

        // クリックした座席を選択状態（青色）に変更
        $seat.removeClass('bg-success').addClass('bg-primary');

        // 選択した座席情報を表示
        const row = $seat.data('row'); // 行情報を取得
        const number = $seat.data('number'); // 番号情報を取得
        $('#selected-seat').text(`選択した座席: ${row}${number}`); // 表示を更新
        $('#reserve-button').prop('disabled', false); // 予約ボタンを有効化

        // モーダルウィンドウに選択した座席情報を設定
        $('#modal-selected-seat').text(`選択した座席: ${row}${number}`);
        $('#modal-row').val(row); // モーダルの隠しフィールドに行情報を設定
        $('#modal-number').val(number); // モーダルの隠しフィールドに番号情報を設定
      }
    });
  });
</script>
@endif

@endsection