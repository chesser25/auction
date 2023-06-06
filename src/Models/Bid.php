<?php

namespace App\Models;

use App\Models\Abstracts\IBuyer;
use App\Models\Abstracts\Model;

class Bid extends Model
{
    private float $amount;
    private IBuyer $buyer;

    public function setAmount(float $amount) : void
    {
        $this->amount = $amount;
    }

    public function getAmount() : float
    {
        return $this->amount;
    }

    public function setBuyer(IBuyer $buyer) : void
    {
        $this->buyer = $buyer;
    }

    public function getBuyer() : IBuyer
    {
        return $this->buyer;
    }
}