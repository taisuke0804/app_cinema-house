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

    public function sendNotification(BulkNotificationRequest $request, BulkNotificationService $service)
    {
        $service->dispatchNotificationJob($request->subject, $request->message);
    }
}
