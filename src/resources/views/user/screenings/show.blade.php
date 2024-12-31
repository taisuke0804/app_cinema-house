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

    <!-- 席予約状況 -->
    <hr>
    <h5>座席予約状況</h5>
    <p class="text-muted">緑色: 空き / 灰色: 予約済み / 青色: 選択中</p>
    <div class="d-flex flex-column align-items-start">
      @foreach (range('A', 'B') as $row)
        <div class="d-flex align-items-center mb-2">
          <span class="me-2">{{ $row }}</span>
          <div class="d-flex">
            
            @foreach (range(1, 10) as $number)
              @php
                $seat = $screening->seats->whereStrict('row', $row)->whereStrict('number', $number)->first();
                $isReserved = $seat->is_reserved ?? 0;
              @endphp
              <div 
                class="seat {{ $isReserved ? 'bg-secondary not-allowed' : 'bg-success clickable' }} 
                text-white me-3 d-flex justify-content-center align-items-center"
                data-row="{{ $row }}"
                data-number="{{ $number }}"
                data-is-reserved="{{ $isReserved }}"
              >
                {{ $row . strval($number) }}
              </div>
            @endforeach

          </div>
        </div>
      @endforeach

      <!-- 選択した座席情報 -->
      <hr>
      <h5>選択した座席情報</h5>
      <p id="selected-seat" class="text-muted">座席が選択されていません。</p>

      <!-- 予約するボタン -->
      <button id="reserve-button" class="btn btn-primary mt-3" disabled>予約する</button>

    </div>

    <!-- Bootstrapのカスタムクラス -->
    <style>
      .seat {
        width: 40px;
        height: 40px;
        font-size: 1rem;
        border-radius: 4px;
      }

      .not-allowed {
        pointer-events: none;
        cursor: not-allowed;
      }
      .clickable {
        cursor: pointer;
      }
    </style>


  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
  $(document).ready(function () {
    $('.seat.bg-success').on('click', function () {
      const $seat = $(this);
      const isReserved = $seat.data('is-reserved');

      // クリックされた座席がすでに選択されている場合（青色）
      if ($seat.hasClass('bg-primary')) {
        $seat.removeClass('bg-primary').addClass('bg-success'); // 空き状態に戻す

        // 座席情報をクリア
        $('#selected-seat').text('座席が選択されていません。');
        $('#reserve-button').prop('disabled', true); // ボタンを無効化
      } 
      // 空き状態の座席をクリックした場合（緑色）
      else if ($seat.hasClass('bg-success')) {
        // 他の選択済み座席をリセット（単一選択の場合）
        $('.seat.bg-primary').removeClass('bg-primary').addClass('bg-success');

        // クリックした座席を選択状態（青色）に変更
        $seat.removeClass('bg-success').addClass('bg-primary');

        // 選択した座席情報を表示
        const row = $seat.data('row');
        const number = $seat.data('number');
        $('#selected-seat').text(`選択した座席: ${row}${number}`);
        $('#reserve-button').prop('disabled', false); // ボタンを有効化
      }

    });
  });
</script>

@endsection