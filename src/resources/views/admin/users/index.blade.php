@extends('layouts.admin')

@section('title', 'ユーザー管理 | CINEMA-HOUSE')

@section('content')
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-start">
    <h2 class="mb-4">ユーザー一覧</h2>
  
    <a href="" class="btn btn-info btn-sm" role="button">
      ユーザー新規登録
    </a>
  </div>

  @if(session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif

  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>名前</th>
          <th>メールアドレス</th>
          <th>登録日</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->created_at->format('Y-m-d') }}</td>
          <td>
            <a href="" class="btn btn-primary btn-sm">詳細</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-start">
    {{ $users->links('vendor.pagination.movie') }}
  </div>
</div>
@endsection