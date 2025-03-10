<?php

declare(strict_types=1);

namespace App\Domains\Orders\Dto;

use App\Domains\Orders\Http\Requests\StoreOrderRequest;
use App\Domains\Users\Models\User;
use Ramsey\Uuid\Uuid;

class StoreOrderDto
{
    public function __construct(
        public string $name,
        public float $amount,
        public string $uuid,
        public User $user,
    ) {
    }

    public static function fromRequest(StoreOrderRequest $request): self
    {
        return new self(
            name: $request->input('name'),
            amount: $request->input('amount'),
            uuid: Uuid::uuid4()->toString(),
            user: auth()->user(),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'amount' => $this->amount,
            'order_uuid' => $this->uuid,
        ];
    }
}