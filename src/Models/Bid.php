<?php

namespace App\Models;

use App\Models\Abstracts\IBuyer;
use App\Models\Abstracts\Model;

class Bid extends Model
{
    private int $amount;
    private IBuyer $buyer;

    public function setAmount(int $amount) : void
    {
        $this->amount = $amount;
    }

    public function getAmount() : int
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