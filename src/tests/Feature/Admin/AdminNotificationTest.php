<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendBulkNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotificationMail;

class AdminNotificationTest extends TestCase
{
    use RefreshDatabase;

    private function create_admin()
    {
        $admin = Admin::factory()->create([
            'name' => '管理者太郎',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1234'),
        ]);
        $this->actingAs($admin, 'admin');

        return $admin;
    }

    public function test_dispatch_bulk_notification_job()
    {
        Queue::fake(); // キュー実行を防ぎつつ監視
        $admin = $this->create_admin();

        // ジョブが投入されないことをアサート
        Queue::assertNothingPushed();

        $response = $this->post(route('admin.notifications.send'), [
            'subject' => 'お知らせ',
            'message' => '近日公開映画のご案内です。',
        ]);

        $response->assertRedirect(); 
        $response->assertSessionHas('status');

        Queue::assertPushed(SendBulkNotificationMail::class);
        
    }

    public function test_job_not_dispatch_validation_fails()
    {
        Queue::fake(); // キュー実行を防ぎつつ監視

        $admin = $this->create_admin();

        $response = $this->post(route('admin.notifications.send'), [
            'subject' => '',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['subject', 'message']);
        Queue::assertNotPushed(SendBulkNotificationMail::class);
    }

    public function test_notification_mail_is_sent_to_all_users()
    {
        Mail::fake();
        Queue::fake();

        $admin = $this->create_admin();

        $users = User::factory()->count(2)->create();

        $response = $this->post(route('admin.notifications.send'), [
            'subject' => 'お知らせ',
            'message' => '近日公開映画のご案内です。',
        ]);

        SendBulkNotificationMail::dispatch($users->pluck('id')->toArray(), 'テスト通知', '本文です')->handle();

        Mail::assertQueued(AdminNotificationMail::class, 2); // 2名に送信されていることを確認

        Mail::assertQueued(AdminNotificationMail::class, function ($mail) {
            return $mail->subjectLine === 'テスト通知' &&
                   $mail->bodyText === '本文です';
        });
    }
}
