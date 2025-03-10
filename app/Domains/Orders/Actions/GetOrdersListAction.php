<?php

declare(strict_types=1);

namespace App\Domains\Orders\Actions;

use App\Domains\Orders\Dto\ListOrdersDto;
use App\Domains\Orders\Repositoties\OrderRepository;
use Illuminate\Database\Eloquent\Collection;

readonly class GetOrdersListAction
{
    public function __construct(private OrderRepository $orderRepository)
    {
    }

    public function execute(ListOrdersDto $dto): Collection
    {
        return $this->orderRepository->getListByUser($dto);
    }
}