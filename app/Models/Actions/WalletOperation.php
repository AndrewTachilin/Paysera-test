<?php

declare(strict_types=1);

namespace App\Models\Actions;

class WalletOperation
{
    public int $userId;

    public string $dateOfAction;

    private string $clientType;

    private string $actionType;

    private float $actionAmount;

    private string $currency;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return $this
     */
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

    public function getActionAmount(): float
    {
        return $this->actionAmount;
    }

    public function setActionAmount(float $actionAmount): self
    {
        $this->actionAmount = $actionAmount;

        return $this;
    }

    /**
     * @return string
     */
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
