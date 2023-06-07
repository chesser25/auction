<?php

namespace App\Tests;

require_once '../vendor/autoload.php';

use App\Factories\Abstracts\IModelFactory;
use App\Factories\ModelFactory;
use App\Factories\ServiceFactory;
use App\Models\Auction;
use App\Models\Buyer;
use App\Services\Abstracts\IAuctionService;
use App\Tests\Abstracts\BaseTest;

class AuctionTest extends BaseTest
{
    private IAuctionService $auctionService;
    private IModelFactory $modelFactory;
    private Auction $auction;

    public function __construct(IModelFactory $modelFactory, IAuctionService $auctionService, Auction $auction)
    {
        $this->auctionService = $auctionService;
        $this->modelFactory = $modelFactory;
        $this->auction = $auction;
    }

    public function test()
    {
        // Arrange
        $buyerA = $this->modelFactory->create(Buyer::class, ['id' => 1, 'username' => 'buyerA']);
        $buyerA->makeBid($this->auctionService, 110);
        $buyerA->makeBid($this->auctionService, 130);

        $buyerB = $this->modelFactory->create(Buyer::class, ['id' => 2, 'username' => 'buyerB']);
        $buyerB->makeBid($this->auctionService, 0);

        $buyerC = $this->modelFactory->create(Buyer::class, ['id' => 3, 'username' => 'buyerC']);
        $buyerC->makeBid($this->auctionService, 125);

        $buyerD = $this->modelFactory->create(Buyer::class, ['id' => 4, 'username' => 'buyerD']);
        $buyerD->makeBid($this->auctionService, 105);
        $buyerD->makeBid($this->auctionService, 115);
        $buyerD->makeBid($this->auctionService, 90);

        $buyerE = $this->modelFactory->create(Buyer::class, ['id' => 5, 'username' => 'buyerE']);
        $buyerE->makeBid($this->auctionService, 132);
        $buyerE->makeBid($this->auctionService, 135);
        $buyerE->makeBid($this->auctionService, 140);

        // Act
        $this->auctionService->start();

        // Assert
        $expectedWinnerPrice = 130;
        $expectedWinner = $buyerE;

        $isWinnerCorrect = assert($expectedWinner->getId() == $this->auction->getWinner()->getId(), 'Winner is wrong!');
        $isWinnerPriceCorrect = assert($expectedWinnerPrice == $this->auction->getWinnerPrice(), 'Winner price is wrong!');
        
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

$serviceFactory = new ServiceFactory();
$auctionService = $serviceFactory->create(IAuctionService::class, ['auction' => $auction]);

(new AuctionTest($modelFactory, $auctionService, $auction))->test();