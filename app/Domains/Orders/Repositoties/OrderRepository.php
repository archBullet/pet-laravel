<?php

declare(strict_types=1);

namespace App\Domains\Orders\Repositoties;

use App\Domains\Orders\Dto\ListOrdersDto;
use App\Domains\Orders\Dto\ShowOrderDto;
use App\Domains\Orders\Dto\StoreOrderDto;
use App\Domains\Orders\Models\Order;
use App\Domains\Orders\Supports\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{
    public function createDraft(StoreOrderDto $dto): Order
    {
        $order = new Order();
        $order->uuid = $dto->uuid;
        $order->owner_uuid = $dto->user->uuid;
        $order->status = OrderStatusEnum::Draft;
        $order->save();

        return $order;
    }
    public function getListByUser(ListOrdersDto $dto): Collection
    {
        return Order::query()
            ->where('owner_uuid', $dto->user->uuid)
            ->get();
    }

    public function getByUserAndUuid(ShowOrderDto $dto): Order
    {
        return Order::query()
            ->where('owner_uuid', $dto->user->uuid)
            ->where('uuid', $dto->uuid)
            ->firstOrFail();
    }

    public function setStatus(Order $order, OrderStatusEnum $status): Order
    {
        $order->status = $status;
        $order->save();

        return $order;
    }
}