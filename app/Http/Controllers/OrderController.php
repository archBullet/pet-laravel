<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Orders\Actions\GetOrderAction;
use App\Domains\Orders\Actions\GetOrdersListAction;
use App\Domains\Orders\Actions\StoreOrderAction;
use App\Domains\Orders\Http\Requests\ListOrderRequest;
use App\Domains\Orders\Http\Requests\ShowOrderRequest;
use App\Domains\Orders\Http\Requests\StoreOrderRequest;
use App\Domains\Orders\Http\Resources\OrderResource;
use App\Domains\Orders\Http\Resources\OrdersResourceCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderController extends Controller
{
    public function index(
        ListOrderRequest $request,
        GetOrdersListAction $action
    ): ResourceCollection {
        $orders = $action->execute($request->dto());

        return OrdersResourceCollection::make($orders);
    }

    public function show(
        ShowOrderRequest $request,
        GetOrderAction $action,
    ): JsonResource {
        $order = $action->execute($request->dto());

        return OrderResource::make($order);
    }

    public function store(
        StoreOrderRequest $request,
        StoreOrderAction $action
    ) {
        $order = $action->execute($request->dto());

        return OrderResource::make($order);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
