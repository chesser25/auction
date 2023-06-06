<?php

namespace App\Models;

class Bid
{
    private float $amount;
    private Buyer $buyer;

    public function setAmount(float $amount) : void
    {
        $this->amount = $amount;
    }

    public function getAmount() : float
    {
        return $this->amount;
    }

    public function setBuyer(Buyer $buyer) : void
    {
        $this->buyer = $buyer;
    }

    public function getBuyer() : Buyer
    {
        return $this->buyer;
    }
}