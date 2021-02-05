<?php

namespace App\Collections;

use App\Models\Actions\WalletOperation;
use Ramsey\Collection\Collection;

class UserHistoryCollection extends Collection
{
    private string $collectionType;

    public function __construct(string $collectionType, array $data = [])
    {
        parent::__construct($collectionType, $data);
    }

    public function getType(): string
    {
        return WalletOperation::class;
    }
}
