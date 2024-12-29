@extends('layouts.admin')

@section('title', '上映カレンダー | CINEMA-HOUSE')

@section('content')
<script src="
https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js
"></script>
<div class="container mt-4">
  <h1 class="mb-4">上映カレンダー</h1>
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
    });

    calendar.render();
  });
</script>
@endsection