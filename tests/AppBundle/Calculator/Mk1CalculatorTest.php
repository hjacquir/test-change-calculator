<?php

namespace Tests\AppBundle\Calculator;

use AppBundle\Calculator\CalculatorInterface;
use AppBundle\Model\Change;
use AppBundle\Calculator\Mk1Calculator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class Mk1CalculatorTest
 * @package Tests\AppBundle\Calculator
 * @covers \AppBundle\Calculator\Mk1Calculator
 */
class Mk1CalculatorTest extends TestCase
{
    /**
     * @var CalculatorInterface
     */
    private $calculator;

    /**
     * @var Change|MockObject
     */
    private $change;

    protected function setUp()
    {
        $this->change = $this->getMockBuilder(Change::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->calculator = new Mk1Calculator($this->change);
    }

    public function testGetSupportedModel()
    {
        $this->assertEquals('mk1', $this->calculator->getSupportedModel());
    }

    public function testGetChangeEasy()
    {
        $change = $this->calculator->getChange(2);
        $this->assertInstanceOf(Change::class, $change);
        $this->assertEquals(2, $change->coin1);
    }
}