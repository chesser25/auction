<?php

namespace App\Tests;

use App\Exceptions\AmountBelowZeroException;
use App\Exceptions\MissingRequiredParamsException;
use App\Exceptions\UserIdAlreadyExistsException;
use App\Factories\ModelFactory;
use App\Factories\ServiceFactory;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Buyer;
use App\Services\Abstracts\IAuctionService;
use App\Services\AuctionService;
use App\Tests\Abstracts\BaseTest;
use Exception;

class AuctionTest extends BaseTest
{
    public function prepare()
    {
        $auction = new Auction(100);

        $this->testData = [
            'auction' => $auction,
            'auction_service' => new AuctionService($auction),
            'model_factory' => new ModelFactory(),
            'service_factory' => new ServiceFactory()
        ];
    }

    /**
     * Test to validate Auction creation using ModelFactory
     */
    public function testTryingToCreateAuctionWithoutPriceField()
    {
        $exception = null;
        try {
            $this->testData['model_factory']->create(Auction::class);
        } catch (Exception $e) {
            $exception = $e;
        }
        $this->assertEqual(MissingRequiredParamsException::class, get_class($exception));
    }

    /**
     * Test to validate Auction creation with price below zero using ModelFactory
     */
    public function testTryingToCreateAuctionWithPriceBelowZero()
    {
        $exception = null;
        try {
            $this->testData['model_factory']->create(Auction::class, ['price' => -1]);
        } catch (Exception $e) {
            $exception = $e;
        }
        $this->assertEqual(AmountBelowZeroException::class, get_class($exception));
    }

    /**
     * Test to validate Buyer creation using ModelFactory
     */
    public function testTryingToCreateBuyerWithoutIdField()
    {
        $exception = null;
        try {
            $this->testData['model_factory']->create(Buyer::class);
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertEqual(MissingRequiredParamsException::class, get_class($exception));
    }

    /**
     * Test to validate Buyer creation using ModelFactory
     */
    public function testTryingToCreateBuyerWithSameId()
    {
        $id = 1;
        $this->testData['model_factory']->create(Buyer::class, ['id' => $id, 'username' => 'test']);
        $exception = null;
        try {
            $this->testData['model_factory']->create(Buyer::class, ['id' => $id, 'username' => 'test 2']);
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertEqual(UserIdAlreadyExistsException::class, get_class($exception));
    }

    /**
     * Test to validate AuctionService creation using ServiceFactory
     */
    public function testTryingToCreateAuctionServiceWithoutAuction()
    {
        $exception = null;
        try {
            $this->testData['service_factory']->create(IAuctionService::class);
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertEqual(MissingRequiredParamsException::class, get_class($exception));
    }

    /**
     * Test add bid with amount below zero
     */
    public function testAddingBidWithAmountBelowZero()
    {
        $buyer = $this->testData['model_factory']->create(Buyer::class, ['id' => 1, 'username' => 'test']);
        $exception = null;
        try {
            $wrongAmount = -1;
            $buyer->makeBid($this->testData['auction_service'], $wrongAmount);
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertEqual(AmountBelowZeroException::class, get_class($exception));
    }

    /**
     * Test add bid with amount below price from Auction model
     */
    public function testAddingBidWithAmountBelowAuctionPrice()
    {
        $buyer = $this->testData['model_factory']->create(Buyer::class, ['id' => 1, 'username' => 'test']);
        $bidAmount = 50;
        $buyer->makeBid($this->testData['auction_service'], $bidAmount);

        $this->assertEmpty($this->testData['auction']->getBids());
    }

    /**
     * Test add bid successfull
     */
    public function testAddingBidSuccess()
    {
        $buyer = $this->testData['model_factory']->create(Buyer::class, ['id' => 1, 'username' => 'test']);
        $buyer->makeBid($this->testData['auction_service'], 125);

        $expectedCount = 1;
        $this->assertCount($expectedCount, $this->testData['auction']->getBids());

        $bids = $this->testData['auction']->getBids();
        $this->assertEqual($buyer->getId(), end($bids)->getBuyer()->getId());
    }

     /**
     * Test adding bid with amount below auction price, using AuctionService
     */
    public function testAddingBidUsingAuctionService()
    {
        $buyer = $this->testData['model_factory']->create(Buyer::class, ['id' => 1, 'username' => 'test']);
        $bidWithAmountBelowAuctionPrice = -1;
        $bid = new Bid();
        $bid->setAmount($bidWithAmountBelowAuctionPrice);
        $bid->setBuyer($buyer);

        $this->testData['auction_service']->addBid($bid);
        
        $this->assertEmpty($this->testData['auction']->getBids());
    }

     /**
     * Test success when adding bid using AuctionService
     */
    public function testAddingBidUsingAuctionServiceSuccess()
    {
        $buyer = $this->testData['model_factory']->create(Buyer::class, ['id' => 1, 'username' => 'test']);
        $bid = new Bid();
        $bid->setAmount(150);
        $bid->setBuyer($buyer);

        $this->testData['auction_service']->addBid($bid);
        
        $expectedCount = 1;
        $this->assertCount($expectedCount, $this->testData['auction']->getBids());

        $bids = $this->testData['auction']->getBids();
        $firstFoundBid = end($bids);
        $this->assertEqual($buyer->getId(), $firstFoundBid->getBuyer()->getId());
    }

    /**
     * Test auction service which gives correct winner and winner price
     */
    public function testAuction()
    {
        $buyerA = $this->testData['model_factory']->create(Buyer::class, ['id' => 1, 'username' => 'buyerA']);
        $buyerA->makeBid($this->testData['auction_service'], 110);
        $buyerA->makeBid($this->testData['auction_service'], 130);

        $buyerB = $this->testData['model_factory']->create(Buyer::class, ['id' => 2, 'username' => 'buyerB']);
        
        $buyerC = $this->testData['model_factory']->create(Buyer::class, ['id' => 3, 'username' => 'buyerC']);
        $buyerC->makeBid($this->testData['auction_service'], 125);
        
        $buyerD = $this->testData['model_factory']->create(Buyer::class, ['id' => 4, 'username' => 'buyerD']);
        $buyerD->makeBid($this->testData['auction_service'], 105);
        $buyerD->makeBid($this->testData['auction_service'], 115);
        $buyerD->makeBid($this->testData['auction_service'], 90);

        $buyerE = $this->testData['model_factory']->create(Buyer::class, ['id' => 5, 'username' => 'buyerE']);
        $buyerE->makeBid($this->testData['auction_service'], 132);
        $buyerE->makeBid($this->testData['auction_service'], 135);
        $buyerE->makeBid($this->testData['auction_service'], 140);

        $this->testData['auction_service']->start();

        $expectedWinnerPrice = 130;
        $expectedWinner = $buyerE;

        $this->assertEqual($expectedWinner->getId(), $this->testData['auction']->getWinner()->getId());
        $this->assertEqual($expectedWinnerPrice, $this->testData['auction']->getWinnerPrice());
    }
}