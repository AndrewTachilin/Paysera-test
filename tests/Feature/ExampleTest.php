<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testCalculateIntReturn()
    {
        $result = $this->artisan('calculate:commission input.csv');

        $this->assertIsInt($result);
    }
}
