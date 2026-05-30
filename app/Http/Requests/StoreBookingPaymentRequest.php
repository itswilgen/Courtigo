<?php

namespace App\Http\Requests;

use App\Services\PaymentMethodCatalog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingPaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $booking = $this->route('booking');

        return $this->user()?->id === $booking?->user_id || $this->user()?->isRole('admin');
    }

    public function rules(): array
    {
        return [
            'payment_method' => ['required', 'string', Rule::in(app(PaymentMethodCatalog::class)->keys())],
        ];
    }
}
