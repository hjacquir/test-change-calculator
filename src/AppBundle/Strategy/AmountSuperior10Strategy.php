<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 17:53
 */

namespace AppBundle\Strategy;

use AppBundle\Model\Change;

/**
 * Class AmountSuperior10Strategy
 * @package AppBundle\Strategy
 */
class AmountSuperior10Strategy implements Strategy
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $result = 0;

    /**
     * Strategy2 constructor.
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return bool
     */
    public function isAppropriate()
    {
        return $this->amount > 10;
    }

    /**
     * @param Change $change
     * @return void
     */
    public function apply(Change $change)
    {
        $this->result = $this->amount % 10;

        $change->bill10 = intdiv($this->amount, 10);
    }

    /**
     * @return int
     */
    public function getModuloRest(): int
    {
        return $this->result;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}