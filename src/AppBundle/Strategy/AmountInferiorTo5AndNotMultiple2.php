<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 18:33
 */

namespace AppBundle\Strategy;

use AppBundle\Calculator\Mk2Calculator;
use AppBundle\Model\Change;

/**
 * Class AmountInferiorTo5AndNotMultiple2
 * @package AppBundle\Strategy
 */
class AmountInferiorTo5AndNotMultiple2 extends ObserverStrategy
{
    /**
     * @return bool
     */
    public function isAppropriate()
    {
        return $this->getAmount() < 5 && false === $this->multipleOf($this->getAmount(), 2);

    }

    /**
     * @param Change $change
     */
    public function apply(Change $change)
    {
        $change->coin2 = Mk2Calculator::OPERATION_IMPOSSIBLE;
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return 0;
    }
}