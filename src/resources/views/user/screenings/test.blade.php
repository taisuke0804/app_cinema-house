@extends('layouts.user')

@section('title', 'ユーザートップページ | CINEMA-HOUSE')

@push('styles')
@vite(['resources/css/screenings.css'])
@endpush

@section('content')

<section class="sc-section">
  <h4>上映スケジュール詳細</h4>

  <div class="sc-show">
    <h5 class="sc-title"><strong>映画タイトル:</strong> 『 Nihil ea tempora. 』</h5>
    <p class="sc-info">
      <strong>ジャンル:</strong> コメディ<br>
      <strong>上映日:</strong> 2025年06月02日<br>
      <strong>上映開始時刻:</strong> 10:45<br>
      <strong>上映終了時刻:</strong> 12:45
    </p>

    <hr>

    <h5 class="seat-info">座席予約状況</h5>
    <p class="reserve-kinds">緑色: 空き / 灰色: 他人の予約 / 黄色: 自分の予約 / 青色: 選択中</p>

    <div class="seat-row">
      <span class="row-label">A</span>
      <div class="seats">
        <button class="seat">A1</button>
        <button class="seat">A2</button>
      </div>
    </div>

    <div class="seat-row">
      <span class="row-label">B</span>
      <div class="seats">
        <button class="seat">B1</button>
        <button class="seat">B2</button>
      </div>
    </div>

    <hr>
    <h5 class="seat-info">選択した座席情報</h5>
    <p class="reserve-state">座席が選択されていません。</p>

    <button class="reserve-button">予約する</button>
  </div>
</section>

@endsection