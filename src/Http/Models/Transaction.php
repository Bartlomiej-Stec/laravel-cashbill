<?php

namespace Barstec\Cashbill\Http\Models;

use Barstec\Cashbill\PaymentDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'order_id';

    protected $guarded = [
        'created_at',
        'updated_at'
    ];

    public function updateOrder(PaymentDetails $paymentDetails): void
    {
        $input = [
            'status' => $paymentDetails->getStatus(),
            'payment_channel' => $paymentDetails->getPaymentChannel(),
            'bank_id' => $paymentDetails->getBankId()
        ];
        $personalData = $paymentDetails->getPersonalData()->getAll();
        foreach (config('cashbill.personal_data_columns') as $column) {
            if (!isset($personalData[$column]) || empty($personalData[$column]))
                continue;
            $input[$column] = $personalData[$column];
        }
        $this->where('order_id', $paymentDetails->getOrderId())->update($input);
    }

    public function add(string $orderId, array $payload): void
    {
        $input = [
            'order_id' => $orderId,
            'title' => $payload['title'],
            'description' => $payload['description'],
            'amount' => $payload['amount.value'],
            'currency_code' => $payload['amount.currencyCode'],
            'payment_channel' => $payload['paymentChannel'],
        ];

        foreach (config('cashbill.personal_data_columns') as $column) {
            if (!isset($payload['personalData.' . $column]))
                continue;
            $input[$column] = $payload['personalData.' . $column];
        }

        $this->create($input);
    }

    public function __construct()
    {
        $this->table = config('cashbill.table_name');
    }
}
