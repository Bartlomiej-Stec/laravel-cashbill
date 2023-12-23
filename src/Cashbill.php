<?php
namespace Barstec\Cashbill;

use Barstec\Cashbill\Exceptions\CashbillException;
use Illuminate\Support\Facades\Http;

abstract class Cashbill
{
    const PRODUCTION = "prod";
    const DEVELOPMENT = "dev";
    const PAYMENT_ENDPOINT = "payment";

    protected abstract function requestInputVerify(): void;

    protected function payloadVerify(): void
    {
        if (empty(config('cashbill.shop_id')) || empty(config('cashbill.secret_key')))
            throw new CashbillException('Environment variables CASHBILL_SHOP_ID and CASHBILL_SECRET_KEY are missing. You can obtain them from your CashBill account.');
        $this->requestInputVerify();
    }

    protected function callApi(array $data, string $method = "POST", string $path = ''): array
    {
        $http = Http::asForm();
        $url = $this->getEndpointUrl($path);
        if ($method == 'POST') {
            $response = $http->post($url, $data);
        } else if ($method == 'GET') {
            $response = $http->get($url, $data);
        }

        if ($response->status() !== 200) {
            throw new CashbillException('HTTP request failed with error code: ' . $response->status() . ' and content: ' . $response->body());
        }

        return $response->json();
    }

    protected function sign(array $requestPayload): string
    {
        return sha1(implode("", $requestPayload) . config('cashbill.secret_key'));
    }

    public function isProd(): bool
    {
        return config('cashbill.mode') === self::PRODUCTION;
    }

    public function isDev(): bool
    {
        return config("cashbill.mode") === self::DEVELOPMENT;
    }

    public function getEndpointUrl(string $path = ''): string
    {
        $baseUrl = $this->isProd() ? config('cashbill.production_url') : config('cashbill.testing_url');
        $url = $baseUrl . self::PAYMENT_ENDPOINT . '/' . config('cashbill.shop_id');
        if($path != '') $url = $url.'/'.$path;
        return $url;
    }
}