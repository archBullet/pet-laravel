<?php

declare(strict_types=1);

namespace App\Domains\Orders\Http\Requests;

use App\Domains\Orders\Dto\ListOrdersDto;
use Illuminate\Foundation\Http\FormRequest;

class ListOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function dto(): ListOrdersDto
    {
        return ListOrdersDto::fromRequest($this);
    }
}