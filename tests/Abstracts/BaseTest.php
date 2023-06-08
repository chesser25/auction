<?php

namespace App\Tests\Abstracts;

abstract class BaseTest
{
    const SUCCESS_MESSAGE = 'Test successfull.';
    const ERROR_MESSAGE = 'Test failed.';
    const SERVICE_METHODS = ['__construct', 'initialize', 'prepare', 'run', 'assertEqual', 'assertEmpty', 'assertCount'];

	public $testData = [];
	public $testMethodsList = [];

	public function __construct()
	{
		var_dump('Initializing tests...');
		$this->initialize();
	}

	public function initialize()
	{
		foreach(get_class_methods($this) as $method) {
			if($method && !in_array($method, self::SERVICE_METHODS)) {
				array_push($this->testMethodsList, $method);
			}
		}
	}

	public function run() {
		var_dump($this->testMethodsList);
		foreach($this->testMethodsList as $testMethod) {
			print("Run test \"{$testMethod}\"\n");
			$this->prepare();
			$this->$testMethod();
			print("Finishing \"{$testMethod}\"\n\n");
		}
	}

    protected function assertEqual($expected, $actual) : void
    {
        try {
            assert($expected == $actual);
            echo self::SUCCESS_MESSAGE . "\n";
        } catch (\Exception $e)
        {
            echo self::ERROR_MESSAGE . "\n";
        }
    }

    protected function assertEmpty(array $list) : void
    {
        try {
            assert(empty($list));
            echo self::SUCCESS_MESSAGE . "\n";
        } catch (\Exception $e)
        {
            echo self::ERROR_MESSAGE . "\n";
        }
    }

    protected function assertCount(int $expectedCount, array $list) : void
    {
        try {
            assert($expectedCount == count($list));
            echo self::SUCCESS_MESSAGE . "\n";
        } catch (\Exception $e)
        {
            echo self::ERROR_MESSAGE . "\n";
        }
    }
}