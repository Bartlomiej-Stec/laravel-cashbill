<?php

namespace Barstec\Cashbill\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $status;
    /**
     * Create a new event instance.
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }
}
