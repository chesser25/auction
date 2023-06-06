<?php

namespace App\Tests;

use App\Models\Auction;
use App\Models\Buyer;

class Test
{
    public function test()
    {
        $auction = new Auction(100);

        $buyerA = $this->getBuyer(1, 'buyerA');
        $buyerA->makeBid($auction, 110);
        $buyerA->makeBid($auction, 130);

        $buyerB = $this->getBuyer(2, 'buyerB');
        $buyerB->makeBid($auction, 0);

        $buyerC = $this->getBuyer(3, 'buyerC');
        $buyerC->makeBid($auction, 125);

        $buyerD = $this->getBuyer(4, 'buyerD');
        $buyerD->makeBid($auction, 105);
        $buyerD->makeBid($auction, 115);
        $buyerD->makeBid($auction, 90);

        $buyerE = $this->getBuyer(5, 'buyerE');
        $buyerE->makeBid($auction, 132);
        $buyerE->makeBid($auction, 135);
        $buyerE->makeBid($auction, 140);

        $response = $auction->start();

        $expectedWinner = $buyerE;
        $expectedWinnerPrice = 130;

        $isWinnerCorrect = assert($expectedWinner->getId(), $response->getWinner()->getId());
        $isWinnerPriceCorrect = assert($expectedWinnerPrice, $response->getWinnerPrice());
        
        if($isWinnerCorrect && $isWinnerPriceCorrect)
        {
            var_export('Tests are successfull');
        }
        else
        {
            var_export('Tests are failed');
        }
    }

    private function getBuyer(int $id, string $name) : Buyer
    {
        $buyer = new Buyer();
        $buyer->setId($id);
        $buyer->setName($name);
        return $buyer;
    }
}
require_once '../vendor/autoload.php';

(new Test())->test();
