<?php

declare(strict_types=1);

namespace App\Services\ApiService\Services;

use App\Domains\Orders\Supports\Enums\OrderStatusEnum;
use App\Services\ApiService\Enums\ApiServiceStatusEnum;

class ApiStatusResolver
{
    public function resolve(ApiServiceStatusEnum $enum): OrderStatusEnum
    {
        return match ($enum) {
          ApiServiceStatusEnum::Pending => OrderStatusEnum::Processing,
          ApiServiceStatusEnum::Completed => OrderStatusEnum::Successful,
          ApiServiceStatusEnum::Failed => OrderStatusEnum::Failed,
          ApiServiceStatusEnum::Cancelled => OrderStatusEnum::Cancelled,
        };
    }
}