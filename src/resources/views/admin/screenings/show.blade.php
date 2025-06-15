@extends('layouts.admin')

@section('title', '上映スケジュール詳細 | CINEMA-HOUSE')

@push('styles')
@vite(['resources/css/screenings.css'])
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
                disabled
              >
                {{ $row }}{{ $seat->number }}
              </button>
            @endforeach
          </div>
        </div>
      @endforeach

    @endif

  </div>
</section>

@endsection