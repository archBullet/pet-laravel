<?php

declare(strict_types=1);

namespace App\Domains\Orders\Http\Requests;

use App\Domains\Orders\Dto\ShowOrderDto;
use Illuminate\Foundation\Http\FormRequest;

class ShowOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order' => ['required', 'uuid']
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'order' => $this->route('order'),
        ]);
    }

    public function dto(): ShowOrderDto
    {
        return ShowOrderDto::fromRequest($this);
    }
}