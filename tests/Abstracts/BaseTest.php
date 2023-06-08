<?php

namespace App\Tests\Abstracts;

abstract class BaseTest
{
    const SUCCESS_MESSAGE = 'Assertion successfull.';
    const ERROR_MESSAGE = 'Assertion failed.';
    const SERVICE_METHODS = ['__construct', 'initialize', 'prepare', 'run', 'assertEqual', 'assertEmpty', 'assertCount'];

	public $testData = [];
	public $testMethodsList = [];

	public function __construct()
	{
		$this->initialize();
	}

	public function initialize()
	{
		foreach(get_class_methods($this) as $method)
        {
			if($method && !in_array($method, self::SERVICE_METHODS))
            {
				array_push($this->testMethodsList, $method);
			}
		}
	}

	public function run() {
		foreach($this->testMethodsList as $testMethod)
        {
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
            print(self::SUCCESS_MESSAGE . "\n");
        } catch (\Exception $e)
        {
            print(self::ERROR_MESSAGE . "\n");
        }
    }

    protected function assertEmpty(array $list) : void
    {
        try {
            assert(empty($list));
            print( self::SUCCESS_MESSAGE . "\n");
        } catch (\Exception $e)
        {
            print(self::ERROR_MESSAGE . "\n");
        }
    }

    protected function assertCount(int $expectedCount, array $list) : void
    {
        try {
            assert($expectedCount == count($list));
            print(self::SUCCESS_MESSAGE . "\n");
        } catch (\Exception $e)
        {
            print(self::ERROR_MESSAGE . "\n");
        }
    }
}