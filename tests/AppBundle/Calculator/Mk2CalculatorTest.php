<?php

namespace Tests\AppBundle\Calculator;

use AppBundle\Calculator\CalculatorInterface;
use AppBundle\Model\Change;
use AppBundle\Calculator\Mk2Calculator;
use PHPUnit\Framework\TestCase;

/**
 * Class Mk2CalculatorTest
 * @package Tests\AppBundle\Calculator
 * @covers \AppBundle\Calculator\Mk2Calculator
 */
class Mk2CalculatorTest extends TestCase
{
    const COIN_1 = 'coin1';
    const COIN_2 = 'coin2';
    const BILL_5 = 'bill5';
    const BILL_10 = 'bill10';

    /**
     * @var CalculatorInterface
     */
    private $calculator;

    /**
     * @var Change
     */
    private $change;

    protected function setUp()
    {
        $this->change = $this->getMockBuilder(Change::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->calculator = new Mk2Calculator($this->change);
    }

    public function testGetSupportedModel()
    {
        $this->assertEquals('mk2', $this->calculator->getSupportedModel());
    }

    public function provideDataForTestChangePossible()
    {
        return [
            'amount2' => [
                2,
                [
                    self::COIN_1 => 0,
                    self::COIN_2 => 1,
                    self::BILL_5 => 0,
                    self::BILL_10 => 0,
                ]
            ],
            'amount10' => [
                10,
                [
                    self::COIN_1 => 0,
                    self::COIN_2 => 0,
                    self::BILL_5 => 0,
                    self::BILL_10 => 1,
                ]
            ],
            'amount11' => [
                21,
                [
                    self::COIN_1 => 0,
                    self::COIN_2 => 3,
                    self::BILL_5 => 1,
                    self::BILL_10 => 1,
                ]
            ],

            'amount16' => [
                16,
                [
                    self::COIN_1 => 0,
                    self::COIN_2 => 3,
                    self::BILL_5 => 0,
                    self::BILL_10 => 1,
                ]
            ],
            'amount17' => [
                17,
                [
                    self::COIN_1 => 0,
                    self::COIN_2 => 1,
                    self::BILL_5 => 1,
                    self::BILL_10 => 1,
                ]
            ],
            'amount15' => [
                15,
                [
                    self::COIN_1 => 0,
                    self::COIN_2 => 0,
                    self::BILL_5 => 1,
                    self::BILL_10 => 1,
                ]
            ],
            'amount53' => [
                53,
                [
                    self::COIN_1 => 0,
                    self::COIN_2 => 4,
                    self::BILL_5 => 1,
                    self::BILL_10 => 4,
                ]
            ],
        ];
    }

    /**
     * @param int $amount
     * @param array $expectedCoinsAndBill
     * @dataProvider provideDataForTestChangePossible
     */
    public function testGetChange($amount, $expectedCoinsAndBill)
    {
        $change = $this->calculator->getChange($amount);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals($expectedCoinsAndBill[self::COIN_1], $change->coin1);
        $this->assertEquals($expectedCoinsAndBill[self::COIN_2], $change->coin2);
        $this->assertEquals($expectedCoinsAndBill[self::BILL_5], $change->bill5);
        $this->assertEquals($expectedCoinsAndBill[self::BILL_10], $change->bill10);
    }

    public function provideDataForChangeImpossible()
    {
        return [
            'amount1' => [1],
            'amount3' => [3],
        ];
    }

    /**
     * @param $currentAmount
     * @dataProvider provideDataForChangeImpossible
     */
    public function testGetChangeImpossible($currentAmount)
    {
        $change = $this->calculator->getChange($currentAmount);
        $this->assertNull($change);
    }
}