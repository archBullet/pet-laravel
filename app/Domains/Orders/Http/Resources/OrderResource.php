<?php

declare(strict_types=1);

namespace App\Domains\Orders\Http\Resources;

use App\Domains\Orders\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Order
 */
class OrderResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'status' => $this->status,
            'uuid' => $this->uuid,
        ];
    }
}