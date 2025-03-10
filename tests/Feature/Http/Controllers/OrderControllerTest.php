<?php

namespace Http\Controllers;

use App\Domains\Orders\Models\Order;
use App\Domains\Orders\Supports\Enums\OrderStatusEnum;
use App\Domains\Users\Models\User;
use App\Services\ApiService\Api\ApiServiceGateway;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    #[DataProvider('storeOrderDataProvider')]
    public function testCreateOrderThrow422(array $request, array $expectedErrors): void
    {
        $this->withoutMiddleware();

        $response = $this->postJson(route('orders.store'), $request);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson($expectedErrors);
    }

    public static function storeOrderDataProvider(): array
    {
        return [
            [
                'request' => [],
                'expectedErrors' => [
                    'errors' => [
                        'name' => ['The name field is required.'],
                        'amount' => ['The amount field is required.'],
                    ]
                ]
            ],
            [
                'request' => ['name' => 1, 'amount' => 'string'],
                'expectedErrors' => [
                    'errors' => [
                        'name' => ['The name field must be a string.'],
                        'amount' => ['The amount field must be a number.'],
                    ]
                ]
            ],
        ];
    }

    public function testAssert401()
    {
        $response = $this->getJson(route('orders.index'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testGetOrdersList(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $ownerOrders = Order::factory()->count(2)->create(['owner_uuid' => $user->uuid]);
        Order::factory()->count(2)->create();

        $response = $this->getJson(route('orders.index'));

        $response->assertOk();
        foreach ($ownerOrders as $order) {
            $response->assertJsonFragment([
                'uuid' => $order->uuid,
                'status' => $order->status,
            ]);
        }
    }

    public function testShowOrder(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $order = Order::factory()->create(['owner_uuid' => $user->uuid]);

        $response = $this->getJson(route('orders.show', ['order' => $order->uuid]));

        $response->assertJson([
            'data' => [
                'status' => $order->status->value,
                'uuid' => $order->uuid,
            ]
        ]);

        $response->assertOk();
    }

    public function testStoreOrder(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $apiServiceUrl = config('services.api_service.url').ApiServiceGateway::CREATE;

        Http::fake([
            $apiServiceUrl => Http::response([
                'data' => [
                    'status' => 3,
                    'uuid' => $this->faker->uuid,
                ]
            ])
        ]);

        $payload = $this->payload();
        $response = $this->post(route('orders.store'), $payload);

        Http::assertSent(function (Request $request) use ($apiServiceUrl, $payload) {
            return $request->url() === $apiServiceUrl
                && Arr::get($request->data(), 'name') === $payload['name']
                && Arr::get($request->headers(),'Authorization') === ['Bearer test_token'];
        });

        $response->assertJson([
            'data' => [
                'status' => OrderStatusEnum::Successful->value,
            ]
        ]);

        $response->assertJsonStructure([
            'data' => [
                'status',
                'uuid',
            ]
        ]);

        $this->assertDatabaseHas(Order::class, [
            'status' => OrderStatusEnum::Successful,
            'owner_uuid' => $user->uuid,
        ]);
    }

    private function payload(): array
    {
        return [
            'name' => $this->faker->word,
            'amount' => 300.50,
        ];
    }
}
