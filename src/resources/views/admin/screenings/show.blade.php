@extends('layouts.admin')

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
    <p class="text-muted">緑色: 空き / 灰色: 予約済み</p>
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
              <div class="seat {{ $isReserved ? 'bg-secondary' : 'bg-success' }} text-white me-3 d-flex justify-content-center align-items-center">
                {{ $row . strval($number) }}
              </div>
            @endforeach

          </div>
        </div>
      @endforeach
    </div>

    <!-- Bootstrapのカスタムクラス -->
    <style>
      .seat {
        width: 40px;
        height: 40px;
        font-size: 1rem;
        border-radius: 4px;
      }
    </style>


  </div>
</div>

@endsection