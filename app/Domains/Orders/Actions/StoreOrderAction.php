<?php

declare(strict_types=1);

namespace App\Domains\Orders\Actions;

use App\Domains\Orders\Dto\StoreOrderDto;
use App\Domains\Orders\Models\Order;
use App\Domains\Orders\Repositoties\OrderRepository;
use App\Domains\Orders\Supports\Enums\OrderStatusEnum;
use App\Services\ApiService\Api\ApiServiceGateway;
use App\Services\ApiService\Services\ApiStatusResolver;
use Illuminate\Support\Facades\Log;

readonly class StoreOrderAction
{
    public function __construct(
        private OrderRepository $orderRepository,
        private ApiServiceGateway $apiGateway,
        private ApiStatusResolver $statusResolver,
    ) {
    }

    public function execute(StoreOrderDto $dto): Order
    {
        $order = $this->orderRepository->createDraft($dto);

        try {
            $response = $this->apiGateway->create($dto);
            $status = $this->statusResolver->resolve($response->status);
        } catch (\Throwable $e) {
            Log::debug('StoreOrderAction execute error: '.$e->getMessage(), [
                'order' => $dto
            ]);

            $status = OrderStatusEnum::Failed;
        }

        return $this->orderRepository->setStatus($order, $status);
    }
}