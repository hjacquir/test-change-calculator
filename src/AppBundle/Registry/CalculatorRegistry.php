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
     * CalculatorRegistry constructor.
     * @param CalculatorInterface[] $calculators
     */
    public function __construct(array $calculators)
    {
        $this->calculators = $calculators;
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