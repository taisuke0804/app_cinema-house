@extends('layouts.admin')

@section('title', '上映スケジュール新規登録 | CINEMA-HOUSE')

@section('content')
<div class="container mt-4">
  <h1 class="mb-4">上映スケジュール新規登録</h1>

  {{-- バリデーションメッセージ --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form id="schedule-form" method="POST" action="{{ route('admin.screenings.store') }}">
    @csrf
    <input type="hidden" name="movie_id" value="{{ $movie->id }}">
    {{-- 映画タイトル --}}
    <div class="mb-3">
      <label for="movie_title" class="form-label">映画タイトル</label>
      <div class="p-3 bg-light border rounded" id="movie_title">
        <span class="fw-bold">{{ $movie->title }}</span>
      </div>
    </div>

    {{-- 上映日付 --}}
    <div class="mb-3" style="max-width: 300px;">
      <label for="date" class="form-label">上映日付</label>
      <input type="date" class="form-control" id="date" name="date" required>
    </div>

    {{-- 上映開始時間 --}}
    <div class="mb-3">
      <label for="start_time_hour" class="form-label">上映開始時間</label>
      <div class="row g-2">
        <div class="col">
          <select class="form-select" id="start_time_hour" name="start_hour" required>
            <option value="" disabled selected>時</option>
            @for ($hour = 9; $hour <= 21; $hour++)
              <option value="{{ $hour }}">{{ $hour }}</option>
            @endfor
          </select>
        </div>
        <div class="col">
          <select class="form-select" id="start_time_minute" name="start_minute" required>
            <option value="" disabled selected>分</option>
            @for ($minute = 0; $minute < 60; $minute += 5)
              <option value="{{ $minute }}">{{ sprintf('%02d', $minute) }}</option>
            @endfor
          </select>
        </div>
      </div>
    </div>

    {{-- 上映終了時間 --}}
    <div class="mb-3">
      <label for="end_time_hour" class="form-label">上映終了時間</label>
      <div class="row g-2">
        <div class="col">
          <select class="form-select" id="end_time_hour" name="end_hour" required>
            <option value="" disabled selected>時</option>
            @for ($hour = 9; $hour <= 21; $hour++)
              <option value="{{ $hour }}">{{ $hour }}</option>
            @endfor
          </select>
        </div>
        <div class="col">
          <select class="form-select" id="end_time_minute" name="end_minute" required>
            <option value="" disabled selected>分</option>
            @for ($minute = 0; $minute < 60; $minute += 5)
              <option value="{{ $minute }}">{{ sprintf('%02d', $minute) }}</option>
            @endfor
          </select>
        </div>
      </div>
    </div>

    {{-- 登録ボタン --}}
    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">登録</button>
    </div>
  </form>
</div>

{{-- 確認用モーダル --}}
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">登録確認</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
      </div>
      <div class="modal-body">
        入力内容を送信してよろしいですか？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        <button type="button" class="btn btn-primary" onclick="document.getElementById('schedule-form').submit();">送信</button>
      </div>
    </div>
  </div>
</div>
@endsection
