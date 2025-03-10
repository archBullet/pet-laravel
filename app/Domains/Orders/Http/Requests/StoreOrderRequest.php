<?php

declare(strict_types=1);

namespace App\Domains\Orders\Http\Requests;

use App\Domains\Orders\Dto\StoreOrderDto;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric'],
        ];
    }

    public function dto(): StoreOrderDto
    {
        return StoreOrderDto::fromRequest($this);
    }
}