<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Admin\BulkNotificationRequest;
use App\Services\Admin\BulkNotificationService;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.index');
    }

    /**
     * ユーザーへ管理者からメールを一斉送信
     */
    public function sendNotification(BulkNotificationRequest $request, BulkNotificationService $service)
    {
        $service->dispatchNotificationJob($request->subject, $request->message);
        
        return back()->with('status', '通知メールを送信しました。');
    }
}
