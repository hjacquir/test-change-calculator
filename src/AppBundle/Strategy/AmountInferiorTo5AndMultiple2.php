<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 18:33
 */

namespace AppBundle\Strategy;

use AppBundle\Model\Change;

/**
 * Class AmountInferiorTo5AndMultiple2
 * @package AppBundle\Strategy
 */
class AmountInferiorTo5AndMultiple2 extends ObserverStrategy
{
    /**
     * @return bool
     */
    public function isAppropriate()
    {
        return $this->getAmount() < 5 && true === $this->multipleOf($this->getAmount(), 2);
    }

    /**
     * @param Change $change
     */
    public function apply(Change $change)
    {
        $change->coin2 += intdiv($this->getAmount(), 2);
    }

    /**
     * @return int
     */
    public function getModuloRest()
    {
        return 0;
    }
}