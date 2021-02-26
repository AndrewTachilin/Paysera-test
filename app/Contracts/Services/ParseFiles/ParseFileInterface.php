<?php

declare(strict_types=1);

namespace App\Contracts\Services\ParseFiles;

interface ParseFileInterface
{
    public function parseFile(string $path): array;
}
