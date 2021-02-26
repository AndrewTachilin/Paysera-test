<?php

declare(strict_types=1);

namespace App\Requests\CurrencyExchange;

use App\Contracts\Services\CurrencyExchange\ExchangeApiInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class CurrencyExchangeApiRequest implements ExchangeApiInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getRates(): array
    {
        $request = new Request('GET', config('app.api_exchange_url'));
        $response = $this->client->send($request);

        try {
            return (array) json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR)['rates'];
        } catch (GuzzleException $exception) {
            throw new RequestException($exception->getMessage(), $request, $response, $exception);
        }
    }
}
