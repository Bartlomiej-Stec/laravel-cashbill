<?php

namespace Barstec\Cashbill;

use Barstec\Cashbill\PersonalData;
use Illuminate\Support\Facades\Route;

class Payload
{
    private ?string $title = null;
    private ?float $amount = null;
    private string $currency;
    private ?string $description = null;
    private ?string $paymentChannel = null;
    private string $languageCode;
    private PersonalData $personalData;
    private ?string $referer = null;
    private array $options = [];
    private string $returnUrl = '';
    private string $negativeReturnUrl = '';
    private ?string $additionalData = null;

    public function __construct()
    {
        $this->setCurrency(config('cashbill.default_currency'));
        $this->setLanguageCode(config('cashbill.default_language'));
        if (Route::has(config('cashbill.default_return_route'))) {
            $this->setReturnUrl(route(config('cashbill.default_return_route')));
        }
        
        if (Route::has(config('cashbill.default_negative_return_route'))) {
            $this->setNegativeReturnUrl(route(config('cashbill.default_negative_return_route')));
        }
        $this->setPersonalData(new PersonalData()); 
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = strtoupper($currency);
    }

    public function setPaymentChannel(string $paymentChannel): void
    {
        $this->paymentChannel = $paymentChannel;
    }

    public function setLanguageCode(string $languageCode): void
    {
        $this->languageCode = strtoupper($languageCode);
    }

    public function setPersonalData(PersonalData $personalData): void
    {
        $this->personalData = $personalData;
    }

    public function setReferer(string $referer): void
    {
        $this->referer = $referer;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function setReturnUrl(string $returnUrl): void
    {
        $this->returnUrl = $returnUrl;
    }

    public function setNegativeReturnUrl(string $negativeReturnUrl): void
    {
        $this->negativeReturnUrl = $negativeReturnUrl;
    }

    public function setAdditionalData(string $additionalData): void
    {
        $this->additionalData = $additionalData;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPaymentChannel(): ?string
    {
        return $this->paymentChannel;
    }

    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    public function getPersonalData(): PersonalData
    {
        return $this->personalData;
    }

    public function getReferer(): ?string
    {
        return $this->referer;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getReturnUrl(): string
    {
        return $this->returnUrl;
    }

    public function getNegativeReturnUrl(): string
    {
        return $this->negativeReturnUrl;
    }

    public function getAdditionalData(): ?string
    {
        return $this->additionalData;
    }

    public function getAll(): array
    {
        $payload['title'] = $this->getTitle() ?? '';
        $payload['amount.value'] = $this->getAmount() ?? 0;
        $payload['amount.currencyCode'] = $this->getCurrency() ?? '';
        $payload['returnUrl'] = $this->getReturnUrl() ?? '';
        $payload['description'] = $this->getDescription();
        $payload['negativeReturnUrl'] = $this->getNegativeReturnUrl() ?? '';
        $payload['additionalData'] = $this->getAdditionalData() ?? '';
        $payload['paymentChannel'] = $this->getPaymentChannel();
        $payload['languageCode'] = $this->getLanguageCode() ?? '';
        $payload['referer'] = $this->getReferer() ?? '';
        $personalData = $this->getPersonalData()->getAll();
        foreach ($personalData as $key => $value) {
            if (!in_array($key, config('cashbill.personal_data_columns')))
                continue;
            $payload['personalData.' . $key] = $personalData[$key];
        }
        $options = $this->getOptions();
        $payload['options'] = implode("", array_map(function ($k, $v) {
            return $k . $v;
        }, array_keys($options), $options));
        return $payload;
    }
}
