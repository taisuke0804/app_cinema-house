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
      <strong>上映日:</strong> {{ $screening->start_time->format('Y年m月d日') }}<br>
      <strong>上映開始時刻:</strong> {{ $screening->start_time->format('H:i') }}<br>
      <strong>上映終了時刻:</strong> {{ $screening->end_time->format('H:i') }}
    </p>

    <!-- 席予約状況 -->
    <hr>
    <h5>座席予約状況</h5>
    <p class="text-muted">緑色: 空き / 灰色: 予約済み</p>
    <div class="d-flex flex-column align-items-start">
      <!-- A列 -->
      <div class="d-flex align-items-center mb-2">
        <span class="me-2">A</span>
        <div class="d-flex">
          <div class="seat bg-success text-white me-3 d-flex justify-content-center align-items-center">A1</div>
          <div class="seat bg-secondary text-white me-3 d-flex justify-content-center align-items-center">A2</div>
          <div class="seat bg-success text-white me-3 d-flex justify-content-center align-items-center">A3</div>
          <div class="seat bg-secondary text-white me-3 d-flex justify-content-center align-items-center">A4</div>
          <div class="seat bg-success text-white me-3 d-flex justify-content-center align-items-center">A5</div>
          <div class="seat bg-secondary text-white me-3 d-flex justify-content-center align-items-center">A6</div>
          <div class="seat bg-success text-white me-3 d-flex justify-content-center align-items-center">A7</div>
          <div class="seat bg-secondary text-white me-3 d-flex justify-content-center align-items-center">A8</div>
          <div class="seat bg-success text-white me-3 d-flex justify-content-center align-items-center">A9</div>
          <div class="seat bg-secondary text-white me-3 d-flex justify-content-center align-items-center">A10</div>
        </div>
      </div>
      <!-- B列 -->
      <div class="d-flex align-items-center mb-2">
        <span class="me-2">B</span>
        <div class="d-flex">
          <div class="seat bg-secondary text-white me-3 d-flex justify-content-center align-items-center">B1</div>
          <div class="seat bg-success text-white me-3 d-flex justify-content-center align-items-center">B2</div>
          <div class="seat bg-secondary text-white me-3 d-flex justify-content-center align-items-center">B3</div>
          <div class="seat bg-success text-white me-3 d-flex justify-content-center align-items-center">B4</div>
          <div class="seat bg-secondary text-white me-3 d-flex justify-content-center align-items-center">B5</div>
          <div class="seat bg-success text-white me-3 d-flex justify-content-center align-items-center">B6</div>
          <div class="seat bg-secondary text-white me-3 d-flex justify-content-center align-items-center">B7</div>
          <div class="seat bg-success text-white me-3 d-flex justify-content-center align-items-center">B8</div>
          <div class="seat bg-secondary text-white me-3 d-flex justify-content-center align-items-center">B9</div>
          <div class="seat bg-success text-white me-3 d-flex justify-content-center align-items-center">B10</div>
        </div>
      </div>
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