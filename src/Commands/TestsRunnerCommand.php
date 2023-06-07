<?php

namespace App\Commands;

define('ROOT_DIR', realpath(__DIR__.'/../..'));
require ROOT_DIR . '/vendor/autoload.php';

use App\Commands\Abstracts\ICommand;
use App\Factories\ModelFactory;
use App\Factories\ServiceFactory;
use App\Models\Auction;
use App\Services\Abstracts\IAuctionService;
use App\Tests\AuctionTest;

class TestsRunnerCommand implements ICommand
{
    public function execute() : void
    {
        $modelFactory = new ModelFactory();
        $price = 100;
        $auction = $modelFactory->create(Auction::class, ['price' => $price]);

        $serviceFactory = new ServiceFactory();
        $auctionService = $serviceFactory->create(IAuctionService::class, ['auction' => $auction]);

        $auctionTest = new AuctionTest($modelFactory, $auctionService, $auction);
        $auctionTest->testAddingBidWithWrongAmount();
        $auctionTest->testAuction();
    }
}

(new TestsRunnerCommand())->execute();