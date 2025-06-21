@extends('layouts.admin')

@section('title', '管理者トップ | CINEMA-HOUSE')

@section('content')
  <h1>管理者トップ</h1>
  <p>ここは管理者トップページです。</p>

  <hr>

  <div class="card mt-4">
    <div class="card-header">
      <h5>ユーザーへの一斉通知メール送信</h5>
    </div>
    <div class="card-body">
      <form id="bulkMailForm" method="POST" action="">
        @csrf

        <div class="mb-3">
          <label for="subject" class="form-label">件名</label>
          <input type="text" name="subject" id="subject" class="form-control" placeholder="（例）新作映画のお知らせ">
        </div>

        <div class="mb-3">
          <label for="message" class="form-label">本文</label>
          <textarea name="message" id="message" rows="6" class="form-control" placeholder="（例）いつもCINEMA-HOUSEをご利用いただきありがとうございます。今週末より新作映画を公開予定です。ぜひご予約ください。&#10;&#10;※この文面はポートフォリオ用のサンプルです。実際の通知内容ではありません。"></textarea>
        </div>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">
          一斉送信
        </button>
      </form>
    </div>
  </div>

  <!-- モーダル -->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">送信確認</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
        </div>
        <div class="modal-body">
          ユーザー全員に通知メールを送信します。よろしいですか？<br>
          <small class="text-muted">※この送信はポートフォリオ用のサンプル機能です。</small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-primary" onclick="document.getElementById('bulkMailForm').submit();">送信する</button>
        </div>
      </div>
    </div>
  </div>
@endsection
