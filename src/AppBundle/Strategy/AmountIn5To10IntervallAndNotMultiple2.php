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
 * Class AmountIn5To10IntervallAndNotMultiple2
 * @package AppBundle\Strategy
 */
class AmountIn5To10IntervallAndNotMultiple2 extends ObserverStrategy
{
    /**
     * @var int
     */
    private $result = 0;

    /**
     * @return bool
     */
    public function isAppropriate()
    {
        return $this->getAmount() > 5 && $this->getAmount() < 10 && false === $this->multipleOf($this->getAmount(), 2);

    }

    /**
     * @param Change $change
     */
    public function apply(Change $change)
    {
        $this->result = $this->getAmount() % 5;

        $change->bill5 += intdiv($this->getAmount(), 5);
    }

    /**
     * @return int
     */
    public function getModuloRest()
    {
        return $this->result;
    }
}