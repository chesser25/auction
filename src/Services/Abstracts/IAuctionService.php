<?php

namespace App\Services\Abstracts;

use App\Models\Bid;

interface IAuctionService
{
    public function addBid(Bid $bid) : void;
    public function start() : void;
}