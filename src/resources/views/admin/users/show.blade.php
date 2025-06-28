@extends('layouts.admin')

@section('title', 'ユーザー詳細 | CINEMA-HOUSE')

@section('content')
<div class="container mt-4">
  <h2 class="mb-4">ユーザー詳細</h2>

  @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="card">
    <div class="card-body">
      <h5 class="card-title fs-2 fw-bold text-primary">{{ $user->name }}</h5>
      <p class="card-text">
        <strong>メールアドレス:</strong> {{ $user->email }}<br>
        <strong>登録日:</strong> {{ $user->created_at->format('Y-m-d') }}
      </p>
      <div class="d-flex justify-content-between">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">戻る</a>
        
        <!-- 削除ボタン（モーダルで確認） -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
          削除
        </button>
      </div>
    </div>
  </div>
</div>

<!-- 削除確認モーダル -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">削除確認</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
      </div>
      <div class="modal-body">
        本当にこのユーザーを削除しますか？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">削除する</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
