<?php
use Barstec\Cashbill\Http\Controllers\CashbillNotificationController;

Route::prefix('api')->group(function () {
    Route::group(['middleware' => ['api']], function () {
        Route::get(config('cashbill.notification_route'), [CashbillNotificationController::class, 'handle'])
            ->name('cashbill.notification');
    });
});
