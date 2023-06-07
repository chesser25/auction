<?php

namespace App\Models\Abstracts;

use App\Services\Abstracts\IAuctionService;

interface IBuyer
{
    public function makeBid(IAuctionService $iAuctionService, int $amount) : void;
}