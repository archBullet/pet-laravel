<?php

declare(strict_types=1);

namespace App\Services\ApiService\Api;

use App\Domains\Orders\Dto\StoreOrderDto;
use App\Services\ApiService\Dto\ApiServiceResponseDto;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Request;

class ApiServiceGateway
{
    protected const int TIMEOUT = 30;

    public const string CREATE = '/create';

    public function create(StoreOrderDto $dto): ApiServiceResponseDto
    {
        $url = config('services.api_service.url').self::CREATE;
        $response = self::send(
            Request::METHOD_POST,
            $url,
            ['json' => $dto->toArray()]
        );

        return ApiServiceResponseDto::fromResponse($response);
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public static function send(string $method, string $url, array $data = []): Response
    {
        $response = Http::timeout(self::TIMEOUT)
            ->contentType('application/json')
            ->withHeaders(['Authorization' => 'Bearer '.config('services.api_service.token')])
            ->send($method, $url, $data);

        if ($response->failed()) {
            $response->throw();
        }

        return $response;
    }
}
