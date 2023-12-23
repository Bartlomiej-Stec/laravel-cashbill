<?php

namespace Barstec\Cashbill\Events;

use Barstec\Cashbill\Payload;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TransactionCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Payload $payload;
    public string $orderId;
    /**
     * Create a new event instance.
     */
    public function __construct(Payload $payload, string $orderId)
    {
        $this->payload = $payload;
        $this->orderId = $orderId;
    }
}
