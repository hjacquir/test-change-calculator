<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 09/06/2020
 * Time: 16:59
 */

namespace Tests\AppBundle\Registry;

use AppBundle\Calculator\CalculatorInterface;
use AppBundle\Calculator\Mk1Calculator;
use AppBundle\Calculator\Mk2Calculator;
use AppBundle\Registry\CalculatorRegistry;
use PHPUnit\Framework\TestCase;

/**
 * Class CalculatorRegistryTest
 * @package Tests\AppBundle\Registry
 * @covers \AppBundle\Registry\CalculatorRegistry
 */
class CalculatorRegistryTest extends TestCase
{
    /**
     * @var CalculatorRegistry
     */
    private $currentRegistry;

    protected function setUp()
    {
        $mk1Calculator = $this->getMockedCalculator(Mk1Calculator::class);
        $mk1Calculator
            ->expects($this->any())
            ->method('getSupportedModel')
            ->willReturn(CalculatorInterface::MK1_MODEL);

        $mk2Calculator = $this->getMockedCalculator(Mk2Calculator::class);
        $mk2Calculator
            ->expects($this->any())
            ->method('getSupportedModel')
            ->willReturn(CalculatorInterface::MK2_MODEL);

        $this->currentRegistry = new CalculatorRegistry();
        $this->currentRegistry->addCalculator($mk1Calculator);
        $this->currentRegistry->addCalculator($mk2Calculator);
    }

    /**
     * @return array
     */
    public function provideDataForSupportedCalculator()
    {
        return [
            'mk1IsSupported' => [
                Mk1Calculator::class,
                CalculatorInterface::MK1_MODEL
            ],
            'mk2IsSupported' => [
                Mk2Calculator::class,
                CalculatorInterface::MK2_MODEL
            ],
        ];
    }

    /**
     * @param string $expectedCalculator
     * @param string $modelName
     *
     * @dataProvider provideDataForSupportedCalculator
     */
    public function testGetCalculatorForReturnAppropriateCalculatorIfItSupported($expectedCalculator, $modelName)
    {
        $this->assertInstanceOf(
            $expectedCalculator,
            $this->currentRegistry->getCalculatorFor($modelName)
        );
    }

    public function testGetCalculatorForReturnNullIfSupportedCalculatorDoNotExist()
    {
        $this->assertNull($this->currentRegistry->getCalculatorFor('foo'));
    }

    /**
     * @param string $className
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function getMockedCalculator($className)
    {
        $calculator = $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();

        return $calculator;
    }
}