<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 09/06/2020
 * Time: 13:44
 */

namespace AppBundle\Calculator;

use AppBundle\Model\Change;
use AppBundle\Strategy\AmountModulo10Rest1;
use AppBundle\Strategy\AmountModulo10Rest3;
use AppBundle\Strategy\Strategy;
use AppBundle\Strategy\AmountEqual10Strategy;
use AppBundle\Strategy\AmountSuperior10Strategy;
use AppBundle\Strategy\AmountModulo10RestNotZero;
use AppBundle\Strategy\AmountEqualTo5;
use AppBundle\Strategy\AmountIn5To10IntervallAndMultiple2;
use AppBundle\Strategy\AmountIn5To10IntervallAndNotMultiple2;
use AppBundle\Strategy\AmountModulo5RestMultipleOf2;
use AppBundle\Strategy\AmountInferiorTo5AndMultiple2;
use AppBundle\Strategy\AmountInferiorTo5AndNotMultiple2;

/**
 * Class Mk2Calculator
 * @package AppBundle\Calculator
 */
class Mk2Calculator implements CalculatorInterface
{
    const OPERATION_IMPOSSIBLE = -1;

    /**
     * @var Change
     */
    private $change;

    /**
     * Mk2Calculator constructor.
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
        return CalculatorInterface::MK2_MODEL;
    }

    /**
     * @param int $amount The amount of money to turn into change
     *
     * @return Change|null The change, or null if the operation is impossible
     */
    public function getChange(int $amount): ?Change
    {
        // @todo avoid to do new here encapsulate all into a Processor object and inject it
        $amountSuperior10Strategy = new AmountSuperior10Strategy($amount);
        $amountEqualTo5 = new AmountEqualTo5($amount);
        $amountIn5To10IntervallAndMultiple2 = new AmountIn5To10IntervallAndMultiple2($amount);
        $amountIn5To10IntervallAndNotMultiple2 = new AmountIn5To10IntervallAndNotMultiple2($amount);
        $amountInferiorTo5AndMultiple2 = new AmountInferiorTo5AndMultiple2($amount);
        $amountInferiorTo5AndNotMultiple2 = new AmountInferiorTo5AndNotMultiple2($amount);

        $amountModulo10RestNotZero = new AmountModulo10RestNotZero($amountSuperior10Strategy);
        $amountModulo10RestNotZero->attach($amountEqualTo5);
        $amountModulo10RestNotZero->attach($amountIn5To10IntervallAndMultiple2);
        $amountModulo10RestNotZero->attach($amountIn5To10IntervallAndNotMultiple2);
        $amountModulo10RestNotZero->attach($amountInferiorTo5AndMultiple2);
        $amountModulo10RestNotZero->attach($amountInferiorTo5AndNotMultiple2);

        $amountModulo5RestMultipleOf2 = new AmountModulo5RestMultipleOf2($amountIn5To10IntervallAndNotMultiple2);
        $amountModulo5RestMultipleOf2->attach($amountInferiorTo5AndMultiple2);
        $amountModulo5RestMultipleOf2->attach($amountInferiorTo5AndNotMultiple2);

        $strategies = [
            new AmountEqual10Strategy($amount),
            $amountSuperior10Strategy,
            new AmountModulo10Rest1($amountSuperior10Strategy),
            new AmountModulo10Rest3($amountSuperior10Strategy),
            $amountModulo10RestNotZero,
            $amountEqualTo5,
            $amountIn5To10IntervallAndMultiple2,
            $amountIn5To10IntervallAndNotMultiple2,
            $amountModulo5RestMultipleOf2,
            $amountInferiorTo5AndMultiple2,
            $amountInferiorTo5AndNotMultiple2,
        ];

        /** @var Strategy $item */
        // @todo encapsulate all this and above to an object like Processor
        foreach ($strategies as $item) {
            if ($item->isAppropriate()) {
                $item->apply($this->change);
            }
        }

        if ($this->change->coin2 === self::OPERATION_IMPOSSIBLE) {
            return null;
        }

        return $this->change;
    }
}