<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReserveCourtRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isRole('player') || $this->user()?->isRole('admin');
    }

    public function rules(): array
    {
        return [
            'court_time_slot_id' => ['required', 'integer'],
        ];
    }
}
