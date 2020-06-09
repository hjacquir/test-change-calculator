<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 09/06/2020
 * Time: 13:20
 */

namespace AppBundle\Calculator;

use AppBundle\Model\Change;

/**
 * Class Mk1Calculator
 * @package AppBundle\Calculator
 */
class Mk1Calculator implements CalculatorInterface
{
    /**
     * @var Change
     */
    private $change;

    /**
     * Mk1Calculator constructor.
     * @param Change $change
     */
    public function __construct(Change $change)
    {
        $this->change = $change;
    }

    /**
     * @return string Indicates the model of automaton
     */
    public function getSupportedModel(): string
    {
        return CalculatorInterface::MK1_MODEL;
    }

    /**
     * @param int $amount The amount of money to turn into change
     *
     * @return Change|null The change, or null if the operation is impossible
     */
    public function getChange(int $amount): ?Change
    {
        $this->change->coin1 = $amount;

        return $this->change;
    }
}