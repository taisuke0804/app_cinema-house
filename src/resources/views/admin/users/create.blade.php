@extends('layouts.admin')

@section('title', 'ユーザー新規登録 | CINEMA-HOUSE')

@section('content')
<div class="container mt-4">
  <h2 class="mb-4">ユーザー新規登録</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form id="user-form" method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">名前</label>
      <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">メールアドレス</label>
      <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">パスワード</label>
      <input type="password" name="password" id="password" class="form-control" >
    </div>

    <div class="mb-3">
      <label for="password_confirmation" class="form-label">パスワード確認</label>
      <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>

    <div class="d-flex justify-content-between">
      <a href="" class="btn btn-secondary">戻る</a>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">登録</button>
    </div>

    <!-- 確認モーダル -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">登録確認</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
          </div>
          <div class="modal-body">
            入力内容で登録してよろしいですか？
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
            <button type="button" class="btn btn-primary" onclick="document.getElementById('user-form').submit();">確定</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection