<?php

namespace App\Services\Admin;

class BulkNotificationService
{
    /**
     * メール送信Jobをディスパッチする（ユーザーID一覧を生成して渡す）
     */
    public function dispatchNotificationJob(string $subject, string $message): void
    {
        dump($subject);
    }
}