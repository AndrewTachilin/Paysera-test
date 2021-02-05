<?php

declare(strict_types=1);

namespace Tests\DataFixtures\Api;

class ApiExchangeRatesArrayFixture
{
    public static function get(): array
    {
        return (array) json_decode('{"rates":{"CAD":1.5358,"HKD":9.3003,"ISK":156.1,"PHP":57.668,"DKK":7.4367,"HUF":355.59,"CZK":25.895,"AUD":1.5727,"RON":4.8755,"SEK":10.1358,"IDR":16838.85,"INR":87.4345,"BRL":6.4285,"RUB":90.6192,"HRK":7.5715,"JPY":126.24,"THB":36.06,"CHF":1.0818,"SGD":1.6025,"PLN":4.4941,"BGN":1.9558,"TRY":8.549,"CNY":7.7542,"NOK":10.338,"NZD":1.6666,"ZAR":18.0297,"USD":1.1996,"MXN":24.2904,"ILS":3.9549,"GBP":0.87693,"KRW":1341.26,"MYR":4.8686},"base":"EUR","date":"2021-02-04"}')->rates;
    }
}
