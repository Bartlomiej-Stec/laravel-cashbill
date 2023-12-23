<?php

namespace Barstec\Cashbill\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cmd' => ['required', 'string', 'in:transactionStatusChanged'],
            'args' => ['required'],
            'sign' => ['required', 'string']
        ];
    }

    public function checkSign(): bool
    {
        return md5($this->cmd . $this->args . config('cashbill.secret_key')) == $this->sign;
    }

    public function getOrderId(): string
    {
        return explode(',', $this->args)[0];
    }

    protected function failedValidation(Validator $validator): void
    {
        abort(403);
    }
}
