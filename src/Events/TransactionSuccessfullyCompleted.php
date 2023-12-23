<?php

namespace Barstec\Cashbill\Events;

use Barstec\Cashbill\PaymentDetails;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionSuccessfullyCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public PaymentDetails $paymentDetails;
    /**
     * Create a new event instance.
     */
    public function __construct(PaymentDetails $paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;    
    }
}
