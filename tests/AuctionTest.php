<?php

namespace App\Tests;

use App\Exceptions\AmountBelowZeroException;
use App\Factories\Abstracts\IModelFactory;
use App\Models\Abstracts\IBuyer;
use App\Models\Auction;
use App\Models\Bid;
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

    public function testAuction()
    {
        $buyerA = $this->modelFactory->create(Buyer::class, ['id' => 1, 'username' => 'buyerA']);
        $this->testAddingBid($buyerA, 110);
        $this->testAddingBid($buyerA, 130);

        $buyerB = $this->modelFactory->create(Buyer::class, ['id' => 2, 'username' => 'buyerB']);
        
        $buyerC = $this->modelFactory->create(Buyer::class, ['id' => 3, 'username' => 'buyerC']);
        $this->testAddingBid($buyerC, 125);
        
        $buyerD = $this->modelFactory->create(Buyer::class, ['id' => 4, 'username' => 'buyerD']);
        $this->testAddingBid($buyerD, 105);
        $this->testAddingBid($buyerD, 115);
        $this->testBidWithLowAmountIsNotAdded($buyerD, 90);

        $buyerE = $this->modelFactory->create(Buyer::class, ['id' => 5, 'username' => 'buyerE']);
        $this->testAddingBid($buyerE, 132);
        $this->testAddingBid($buyerE, 135);
        $this->testAddingBid($buyerE, 140);

        $this->auctionService->start();

        $expectedWinnerPrice = 130;
        $expectedWinner = $buyerE;

        $this->assertEqual($expectedWinner->getId(), $this->auction->getWinner()->getId());
        $this->assertEqual($expectedWinnerPrice, $this->auction->getWinnerPrice());
    }

    public function testAddingBidWithWrongAmount()
    {
        $buyerA = $this->modelFactory->create(Buyer::class, ['id' => 1, 'username' => 'buyerA']);
        $exception = null;
        try {
            $wrongAmount = -1;
            $buyerA->makeBid($this->auctionService, $wrongAmount);
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertEqual(AmountBelowZeroException::class, get_class($exception));
    }

    // Helper functions
    private function testAddingBid(IBuyer $buyer, int $amount)
    {
        $buyer->makeBid($this->auctionService, $amount);
        $this->assertEqual($amount, $this->getLatestAddedBid()->getAmount());
    }

    private function testBidWithLowAmountIsNotAdded(IBuyer $buyer, int $amount)
    {
        $buyer->makeBid($this->auctionService, $amount);
        $bids = array_filter($this->auction->getBids(), function(Bid $bid) use ($amount) {
            return $bid->getAmount() == $amount;
        });
        $this->assertEmpty($bids);
    }
    
    private function getLatestAddedBid() : Bid
    {
        $bids = $this->auction->getBids();
        return end($bids);
    }
}