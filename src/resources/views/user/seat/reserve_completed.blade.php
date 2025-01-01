@extends('layouts.app')

@section('title', '予約完了 | CINEMA-HOUSE')

@section('content')

<div class="card mt-5">
    <div class="card-header bg-success text-white">
        予約完了
    </div>
    <div class="card-body text-center">
        <h5 class="card-title">座席予約が完了しました</h5>
        <p class="card-text">{{ $successMessage }}</p>
        <a href="{{ route('home') }}" class="btn btn-primary">ホームに戻る</a>
    </div>
</div>

@endsection
