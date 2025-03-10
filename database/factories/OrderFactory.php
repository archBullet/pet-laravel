<?php

namespace Database\Factories;

use App\Domains\Orders\Models\Order;
use App\Domains\Orders\Supports\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'status' => Arr::random(OrderStatusEnum::cases()),
            'owner_uuid' => $this->faker->uuid,
        ];
    }
}
