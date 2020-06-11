<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 09/06/2020
 * Time: 16:48
 */

namespace AppBundle\Registry;

use AppBundle\Calculator\CalculatorInterface;

/**
 * Class CalculatorRegistry
 * @package AppBundle\Registry
 */
class CalculatorRegistry implements CalculatorRegistryInterface
{
    /**
     * @var CalculatorInterface[]
     */
    private $calculators = [];

    /**
     * @param CalculatorInterface $calculator
     */
    public function addCalculator(CalculatorInterface $calculator)
    {
        if (!in_array($calculator, $this->calculators)) {
            array_push($this->calculators, $calculator);
        }
    }

    /**
     * @param string $model Indicates the model of automaton
     *
     * @return CalculatorInterface|null The calculator, or null if no CalculatorInterface supports that model
     */
    public function getCalculatorFor(string $model): ?CalculatorInterface
    {
        /** @var CalculatorInterface $calculator */
        foreach ($this->calculators as $calculator) {
            if ($calculator->getSupportedModel() === $model) {
                return $calculator;
            }
        }

        return null;
    }
}