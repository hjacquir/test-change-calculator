<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 18:14
 */

namespace AppBundle\Strategy;

use AppBundle\Model\Change;

/**
 * Class AmountEqualTo5
 * @package AppBundle\Strategy
 */
class AmountEqualTo5 extends ObserverStrategy
{
    /**
     * @return bool
     */
    public function isAppropriate()
    {
        return $this->getAmount() === 5;
    }

    /**
     * @param Change $change
     */
    public function apply(Change $change)
    {
        $change->bill5 += 1;
    }
}