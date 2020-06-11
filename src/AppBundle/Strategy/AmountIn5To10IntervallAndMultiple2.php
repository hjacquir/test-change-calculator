<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 18:18
 */

namespace AppBundle\Strategy;

use AppBundle\Model\Change;

/**
 * Class AmountIn5To10IntervallAndMultiple2
 * @package AppBundle\Strategy
 */
class AmountIn5To10IntervallAndMultiple2 extends ObserverStrategy
{
    /**
     * @return bool
     */
    public function isAppropriate()
    {
        return $this->getAmount() > 5 && $this->getAmount() < 10 && true === $this->multipleOf($this->getAmount(), 2);

    }

    /**
     * @param Change $change
     */
    public function apply(Change $change)
    {
        $change->coin2 += intdiv($this->getAmount(), 2);
    }
}