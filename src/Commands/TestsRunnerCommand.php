<?php

namespace App\Commands;

define('ROOT_DIR', realpath(__DIR__.'/../..'));
require ROOT_DIR . '/vendor/autoload.php';

use App\Commands\Abstracts\ICommand;
use App\Tests\AuctionTest;

class TestsRunnerCommand implements ICommand
{
    public function execute() : void
    {
        (new AuctionTest())->run();
    }
}

(new TestsRunnerCommand())->execute();