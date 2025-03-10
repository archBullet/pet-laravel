<?php

declare(strict_types=1);

namespace App\Domains\Orders\Actions;

use App\Domains\Orders\Dto\ShowOrderDto;
use App\Domains\Orders\Models\Order;
use App\Domains\Orders\Repositoties\OrderRepository;

readonly class GetOrderAction
{
    public function __construct(private OrderRepository $orderRepository)
    {
    }

    public function execute(ShowOrderDto $dto): Order
    {
        return $this->orderRepository->getByUserAndUuid($dto);
    }
}