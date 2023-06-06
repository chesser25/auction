<?php

namespace App\Models\Abstracts;

use App\Models\Auction;

interface IBuyer
{
    public function makeBid(Auction $auction, float $amount) : void;
}