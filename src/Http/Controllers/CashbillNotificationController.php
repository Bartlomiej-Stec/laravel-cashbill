<?php

namespace Barstec\Cashbill\Http\Controllers;

use Barstec\Cashbill\Events\TransactionStatusChanged;
use Barstec\Cashbill\Order;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Barstec\Cashbill\Http\Requests\NotificationRequest;
use Barstec\Cashbill\Events\TransactionSuccessfullyCompleted;

class CashbillNotificationController extends Controller
{
    public function handle(NotificationRequest $request): Response
    {
        if (!$request->checkSign())
            abort(403);

        $orderId = $request->getOrderId();
        $order = new Order($orderId);
        $paymentDetails = $order->update();
        if ($order->isPositiveFinish()) {
            event(new TransactionSuccessfullyCompleted($paymentDetails));
        } else if ($order->statusChanged()) {
            event(new TransactionStatusChanged($paymentDetails->getStatus()));
        }
        return response('OK');
    }
}
