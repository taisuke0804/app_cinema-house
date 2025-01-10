<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>予約情報PDF</title>
<style>
/* 基本の文字 */
@font-face {
    font-family: 'NotoSansJP';
    font-style: normal;
    font-weight: normal;
    src: url('{{ storage_path("fonts/NotoSansJP-Regular.ttf") }}');
}
@font-face {
    font-family: 'NotoSansJP';
    font-style: bold;
    font-weight: bold;
    src: url('{{ storage_path("fonts/NotoSansJP-Bold.ttf") }}');
}

/* 全体のスタイル */
html, body {
    font-family: 'NotoSansJP', sans-serif;
    margin: 0;
    padding: 0;
    background: #fff;
    color: #333;
    line-height: 1.6;
}

/* コンテナ */
.container {
    padding: 20px;
    margin: auto;
    width: 80%;
    border: 1px solid #ccc;
    border-radius: 10px;
    margin-top: 40px;
}

/* タイトル */
.title {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

/* 映画情報 */
.movie-info {
    margin-bottom: 20px;
}

.movie-info p {
    font-size: 16px;
    margin: 5px 0;
}

/* 注意文 */
.notice {
    margin-top: 20px;
    font-size: 14px;
    color: #555;
    text-align: center;
}
</style>
</head>
<body>
<div class="container">
    {{-- アプリタイトル --}}
    <div class="title">CINEMA-HOUSE</div>

    {{-- 映画情報 --}}
    <div class="movie-info">
        <p><strong>上映タイトル :</strong> {{ $reservationData->screening->movie->title }}</p>
        <p>
          <strong>上映日 :</strong> {{ \Carbon\Carbon::parse($reservationData->screening->start_time)->isoFormat('YYYY年MM月DD日（ddd曜日）') }}
        </p>
        <p>
          <strong>上映時間 :</strong> {{ $reservationData->screening->start_time->format('H:i') }} ～ {{ $reservationData->screening->end_time->format('H:i') }}
        </p>
        <p><strong>座席 :</strong> {{ $reservationData->row .  strval($reservationData->number) }}</p>
        <p><strong>名前 :</strong> {{ $userName }} 様</p>
    </div>

    {{-- 注意文 --}}
    <div class="notice">
        入場の際はこちらの画面をご提示ください。
    </div>
</div>
</body>
</html>
