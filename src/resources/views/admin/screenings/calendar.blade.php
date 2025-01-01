@extends('layouts.admin')

@section('title', '上映カレンダー | CINEMA-HOUSE')

@section('content')
<script src="
https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js
"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<div class="container mt-4">
  <h1 class="mb-4">上映カレンダー</h1>

  {{-- フラッシュメッセージ --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="閉じる"></button>
    </div>
  @endif
  
  <div id="calendar"></div>
</div>
<style>
  .fc-day-sat {
    background-color: #cce3f6;
  }

  .fc-day-sun {
    background-color: #f8d7da;
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'ja', // 日本語対応
      buttonText: {
        today: '今月',
        month: '月',
        list: 'リスト'
      },
      firstDay: 1, // 週の最初を月曜日に設定
      events: "{{ route('admin.screenings.calendar.events') }}", // イベント取得URL
      eventDidMount: function (info) {
        // ツールチップを設定
        var tooltip = new tippy(info.el, {
          content: 'タイトル: 『' + info.event.title + '』<br>上映開始: ' + info.event.extendedProps.start_time + '<br>上映終了: ' + info.event.extendedProps.end_time,
          allowHTML: true, // HTMLを許可
          animation: false,
          theme: 'light-border',
          trigger: 'mouseenter',
          placement: 'top',
        });
      },
    });

    calendar.render();
  });
</script>
@endsection
