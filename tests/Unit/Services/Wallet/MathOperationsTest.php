<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Wallet;

use App\Services\Wallet\MathOperations;
use Tests\TestCase;

class MathOperationsTest extends TestCase
{
    private MathOperations $mathOperations;

    public function setUp(): void
    {
        parent::setUp();

        $this->mathOperations = new MathOperations();
    }

    public function testCalculateCommissionReturnCommission(): void
    {
        $fromAmount = '1000';
        $percent = '10';

        $result = $this->mathOperations->calculateCommission($fromAmount, $percent, 4);

        $this->assertEquals(100, $result);
    }

    public function testCalculateCommissionReturnCommissionWithFloat(): void
    {
        $fromAmount = '10';
        $percent = '0.1';
        $result = $this->mathOperations->calculateCommission($fromAmount, $percent, 4);

        $this->assertEquals('0.0100', $result);
    }

    public function testConvertCurrencyReturnInt(): void
    {
        $currency = '10.00';
        $rate = '5';
        $result = $this->mathOperations->convertCurrency($currency, $rate);

        $this->assertEquals(50, $result);
    }

    public function testRoundToThousandthsWithBelowFiveValueReturnHigherValue(): void
    {
        $number = '10.123';
        $result = $this->mathOperations->roundToThousandths($number);

        $this->assertEquals(10, $result);
    }
}
