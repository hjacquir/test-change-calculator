<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 18:00
 */

namespace AppBundle\Strategy;

use AppBundle\Model\Change;

/**
 * Class AmountModulo10Rest1
 * @package AppBundle\Strategy
 */
class AmountModulo10Rest1 implements Strategy
{
    /**
     * @var AmountSuperior10Strategy
     */
    private $amountSuperior10Strategy;

    /**
     * AmountModulo10RestNotZero constructor.
     * @param AmountSuperior10Strategy $amountSuperior10Strategy
     */
    public function __construct(AmountSuperior10Strategy $amountSuperior10Strategy)
    {
        $this->amountSuperior10Strategy = $amountSuperior10Strategy;
    }

    /**
     * @return bool
     */
    public function isAppropriate()
    {
        return $this->getResult() === 1;
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->amountSuperior10Strategy->getResult();
    }

    /**
     * @param Change $change
     */
    public function apply(Change $change)
    {
        $diff = $this->amountSuperior10Strategy->getAmount() - 11;

        $change->bill10 = intdiv($diff, 10);
        $change->bill5 = 1;
        $change->coin2 = 3;
    }
}