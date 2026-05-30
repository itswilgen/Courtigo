<?php

namespace App\Services;

class PaymentMethodCatalog
{
    public function all(): array
    {
        return [
            'gcash' => [
                'label' => 'GCash',
                'hint' => 'Fast mobile wallet payment',
                'detail' => 'Use your GCash app and keep the reference for venue verification.',
                'accent' => 'blue',
            ],
            'bank_transfer' => [
                'label' => 'Bank Transfer',
                'hint' => 'Pay from your bank app',
                'detail' => 'Transfer from your preferred bank and present the confirmation receipt.',
                'accent' => 'slate',
            ],
            'paymaya' => [
                'label' => 'PayMaya',
                'hint' => 'Maya wallet payment',
                'detail' => 'Pay with Maya and keep your transaction receipt handy.',
                'accent' => 'green',
            ],
            'cash_venue' => [
                'label' => 'Pay Cash at Venue',
                'hint' => 'Settle at the front desk',
                'detail' => 'Your slot is reserved. Pay in person before court time.',
                'accent' => 'amber',
            ],
        ];
    }

    public function keys(): array
    {
        return array_keys($this->all());
    }

    public function label(string $method): string
    {
        return $this->all()[$method]['label'] ?? 'Payment';
    }
}
