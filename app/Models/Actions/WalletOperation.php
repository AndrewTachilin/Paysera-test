<?php

declare(strict_types=1);

namespace App\Models\Actions;

class WalletOperation
{
    public int $userId;

    public string $dateOfAction;

    private string $clientType;

    private string $actionType;

    private int $actionAmount;

    private string $currency;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getDateOfAction(): string
    {
        return $this->dateOfAction;
    }

    public function setDateOfAction(string $dateOfAction): self
    {
        $this->dateOfAction = $dateOfAction;

        return $this;
    }

    public function getClientType(): string
    {
        return $this->clientType;
    }

    public function setClientType(string $clientType): self
    {
        $this->clientType = $clientType;

        return $this;
    }

    public function getActionType(): string
    {
        return $this->actionType;
    }


    public function setActionType(string $actionType): self
    {
        $this->actionType = $actionType;

        return $this;
    }

    public function getActionAmount(): int
    {
        return $this->actionAmount;
    }

    public function setActionAmount(int $actionAmount): self
    {
        $this->actionAmount = $actionAmount;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
