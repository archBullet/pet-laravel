<?php

declare(strict_types=1);

namespace App\Domains\Orders\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrdersResourceCollection extends ResourceCollection
{
    public $collects = OrderResource::class;

    public function toArray(Request $request)
    {
        return $this->collection->toArray();
    }
}