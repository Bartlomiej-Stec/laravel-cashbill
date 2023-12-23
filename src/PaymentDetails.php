<?php
namespace Barstec\Cashbill;

class PaymentDetails
{
    private string $orderId;
    private ?string $paymentChannel;
    private float $amount;
    private string $currency;
    private string $title;
    private string $description;
    private PersonalData $personalData;
    private string $additionalData;
    private string $status;
    private ?string $bankId;

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getPaymentChannel(): ?string
    {
        return $this->paymentChannel;
    }

    public function setPaymentChannel(?string $paymentChannel): void
    {
        $this->paymentChannel = $paymentChannel;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPersonalData(): PersonalData
    {
        return $this->personalData;
    }

    public function setPersonalData(PersonalData $personalData): void
    {
        $this->personalData = $personalData;
    }

    public function getAdditionalData(): string
    {
        return $this->additionalData;
    }

    public function setAdditionalData(string $additionalData): void
    {
        $this->additionalData = $additionalData;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getBankId(): ?string
    {
        return $this->bankId;
    }

    public function setBankId(?string $bankId): void
    {
        $this->bankId = $bankId;
    }
}
