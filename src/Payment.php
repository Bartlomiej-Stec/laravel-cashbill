<?php

namespace Barstec\Cashbill;

use Barstec\Cashbill\Http\Models\Transaction;
use Barstec\Cashbill\Exceptions\CashbillException;
use Illuminate\Http\RedirectResponse;
use Barstec\Cashbill\Events\TransactionCreated;

class Payment extends Cashbill
{
    private Payload $payload;

    protected function addSign(array &$requestPayload): void
    {
        $requestPayload['sign'] = $this->sign($requestPayload);
    }

    protected function requestInputVerify(): void
    {
        if (is_null($this->payload->getTitle()))
            throw new CashbillException('Title of transaction is missing');

        if (is_null($this->payload->getAmount()))
            throw new CashbillException('Amount of transaction is missing');

        if (is_null($this->payload->getCurrency()))
            throw new CashbillException('Currency code of transaction is missing');

        if (strlen($this->payload->getCurrency()) !== 3)
            throw new CashbillException('Invalid currency code');

        if (!preg_match('/^\d{1,6}([.]\d{1,2})?$/', $this->payload->getAmount()) || $this->payload->getAmount() <= 0)
            throw new CashbillException('Amount must be float, greater than 0 value');
    }

    protected function beginTransaction(): string
    {
        $this->payloadVerify();
        $requestPayload = $this->payload->getAll();
        $this->addSign($requestPayload);
        $response = $this->callApi($requestPayload);
        $transaction = new Transaction();
        $transaction->add($response['id'], $requestPayload);
        event(new TransactionCreated($this->payload, $response['id']));
        return $response['redirectUrl'];
    }

    public function redirect(): RedirectResponse
    {
        return redirect($this->beginTransaction());
    }

    public function __construct(Payload $payload)
    {
        $this->payload = $payload;
    }


}