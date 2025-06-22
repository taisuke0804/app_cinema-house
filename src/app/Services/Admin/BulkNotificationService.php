<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Jobs\SendBulkNotificationMail;

class BulkNotificationService
{
    /**
     * メール送信Jobをディスパッチする（ユーザーID一覧を生成して渡す）
     */
    public function dispatchNotificationJob(string $subject, string $message): void
    {
        $userIds = User::pluck('id')->toArray(); // 全ユーザーのID取得

        SendBulkNotificationMail::dispatch($userIds, $subject, $message);
    }
}