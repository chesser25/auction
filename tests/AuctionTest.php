<?php

namespace App\Tests;

require_once '../vendor/autoload.php';

use App\Factories\Abstracts\IModelFactory;
use App\Factories\ModelFactory;
use App\Models\Abstracts\IAuction;
use App\Models\Auction;
use App\Models\Buyer;
use App\Tests\Abstracts\BaseTest;

class AuctionTest extends BaseTest
{
    private IAuction $auction;
    private IModelFactory $modelFactory;

    public function __construct(IModelFactory $modelFactory, IAuction $auction)
    {
        $this->auction = $auction;
        $this->modelFactory = $modelFactory;
    }

    public function test()
    {
        // Arrange
        $buyerA = $this->modelFactory->create(Buyer::class, ['id' => 1, 'username' => 'buyerA']);
        $buyerA->makeBid($this->auction, 110);
        $buyerA->makeBid($this->auction, 130);

        $buyerB = $this->modelFactory->create(Buyer::class, ['id' => 2, 'username' => 'buyerB']);
        $buyerB->makeBid($this->auction, 0);

        $buyerC = $this->modelFactory->create(Buyer::class, ['id' => 3, 'username' => 'buyerC']);
        $buyerC->makeBid($this->auction, 125);

        $buyerD = $this->modelFactory->create(Buyer::class, ['id' => 4, 'username' => 'buyerD']);
        $buyerD->makeBid($this->auction, 105);
        $buyerD->makeBid($this->auction, 115);
        $buyerD->makeBid($this->auction, 90);

        $buyerE = $this->modelFactory->create(Buyer::class, ['id' => 5, 'username' => 'buyerE']);
        $buyerE->makeBid($this->auction, 132);
        $buyerE->makeBid($this->auction, 135);
        $buyerE->makeBid($this->auction, 140);

        // Act
        $response = $this->auction->start();

        // Assert
        $expectedWinnerPrice = 130;
        $expectedWinner = $buyerE;

        $isWinnerCorrect = assert($expectedWinner->getId() == $response->getWinner()->getId(), 'Winner is wrong!');
        $isWinnerPriceCorrect = assert($expectedWinnerPrice == $response->getWinnerPrice(), 'Winner price is wrong!');
        
        // Show result
        if($isWinnerCorrect && $isWinnerPriceCorrect)
        {
            var_export('Tests are successfull');
        }
    }
}

// Tests entrypoint
$modelFactory = new ModelFactory();
$price = 100;
$auction = $modelFactory->create(Auction::class, ['price' => $price]);
(new AuctionTest($modelFactory, $auction))->test();