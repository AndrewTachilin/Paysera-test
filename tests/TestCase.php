<?php

declare(strict_types=1);

namespace Tests;

use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
