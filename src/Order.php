<?php
namespace Barstec\Cashbill;

use Barstec\Cashbill\Http\Models\Transaction;
use Barstec\Cashbill\Exceptions\CashbillException;

class Order extends Cashbill
{
    const STATUSES = [
        'PreStart',
        'Start',
        'NegativeAuthorization',
        'Abort',
        'Fraud',
        'PositiveAuthorization',
        'PositiveFinish',
        'NegativeFinish'
    ];

    const FINAL_STATUSES = [
        'Fraud',
        'PositiveFinish',
        'NegativeFinish'
    ];

    const POSITIVE_FINISH = 'PositiveFinish';

    private string $orderId;
    private ?string $lastStatus;

    private function checkStatusChanged(string $status): void
    {
        $currentStatus = Transaction::where('order_id', $this->orderId)->first()->pluck('status');
        if ($this->statusExists($status) && $currentStatus !== $status && !$this->isFinalStatus($currentStatus))
            $this->lastStatus = $status;

    }

    protected function requestInputVerify(): void
    {
        if (empty($this->orderId) || !Transaction::where('order_id', $this->orderId)->exists()) {
            throw new CashbillException('Transaction order ID: ' . $this->orderId . ' is invalid');
        }
    }

    protected function createPersonalData(array $data): PersonalData
    {
        $personalData = new PersonalData();
        $personalData->setFirstName($data['firstName']);
        $personalData->setSurname($data['surname']);
        $personalData->setEmail($data['email']);
        $personalData->setCountry($data['country']);
        $personalData->setCity($data['city']);
        $personalData->setPostcode($data['postcode']);
        $personalData->setStreet($data['street']);
        $personalData->setHouse($data['house']);
        $personalData->setFlat($data['flat']);
        $personalData->setIp($data['ip']);
        return $personalData;
    }

    protected function createPaymentDetails(array $cashbillResponse): PaymentDetails
    {
        //dd($cashbillResponse);
        $paymentDetails = new PaymentDetails();
        $paymentDetails->setOrderId($this->orderId);
        $paymentDetails->setPaymentChannel($cashbillResponse['paymentChannel']);
        $paymentDetails->setAmount($cashbillResponse['amount']['value']);
        $paymentDetails->setCurrency($cashbillResponse['amount']['currencyCode']);
        $paymentDetails->setTitle($cashbillResponse['title']);
        $paymentDetails->setDescription($cashbillResponse['description']);
        $paymentDetails->setPersonalData($this->createPersonalData($cashbillResponse['personalData']));
        $paymentDetails->setAdditionalData($cashbillResponse['additionalData']);
        $paymentDetails->setStatus($cashbillResponse['status']);
        $paymentDetails->setBankId($cashbillResponse['details']['bankId']);
        return $paymentDetails;
    }

    public function isFinalStatus(string $status): bool
    {
        return in_array($status, self::FINAL_STATUSES);
    }

    public function statusExists(string $status): bool
    {
        return in_array($status, self::STATUSES);
    }

    public function statusChanged(): bool
    {
        return !is_null($this->lastStatus);
    }

    public function isPositiveFinish(): bool
    {
        return $this->lastStatus === self::POSITIVE_FINISH;
    }

    public function update(): PaymentDetails
    {
        $this->payloadVerify();
        $sign = $this->sign(['orderId' => $this->orderId]);
        $response = $this->callApi(['sign' => $sign], 'GET', $this->orderId);
        $paymentDetails = $this->createPaymentDetails($response);
        $this->checkStatusChanged($response['status']);
        if ($this->statusChanged()) {
            $transaction = new Transaction();
            $transaction->updateOrder($paymentDetails);
        }
        return $paymentDetails;
    }

    public function __construct(string $orderId)
    {
        $this->orderId = $orderId;
        $this->lastStatus = null;
    }
}