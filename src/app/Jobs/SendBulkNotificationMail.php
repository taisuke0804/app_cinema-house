<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Mail;

/**
 * 管理者からユーザーへの一斉送信メールのjobクラス
 */
class SendBulkNotificationMail implements ShouldQueue
{
    use Queueable;

    protected array $userIds;
    protected string $subject;
    protected string $message;

    /**
     * ジョブで使うデータ
     */
    public function __construct(array $userIds, string $subject, string $message)
    {
        $this->userIds = $userIds;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * キューで実行される処理
     */
    public function handle(): void
    {
        User::whereIn('id', $this->userIds)
            ->chunk(100, function (Collection $users) {
                foreach ($users as $user) {
                    Mail::to($user->email)->queue(
                        new AdminNotificationMail($this->subject, $this->message)
                    );
                }
            });
    }
}
