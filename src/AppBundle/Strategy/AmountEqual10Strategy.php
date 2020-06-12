<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 17:52
 */

namespace AppBundle\Strategy;

use AppBundle\Model\Change;

/**
 * Class AmountEqual10Strategy
 * @package AppBundle\Strategy
 * @todo add Order or on strategy and add Guardian to check if order is OK
 */
class AmountEqual10Strategy implements Strategy
{
    /**
     * @var int
     */
    private $amount;

    /**
     * Strategy1 constructor.
     * @param int $amout
     */
    public function __construct(int $amout)
    {
        $this->amount = $amout;
    }

    /**
     * @return bool
     * @todo in all strategies encapsulate the condition into an Condition object and inject it to make strategy uniform
     */
    public function isAppropriate()
    {
        return $this->amount === 10;
    }

    /**
     * @param Change $change
     * @todo il all strategies encapsulate the action into an Action object and inject it to make strategy uniform
     */
    public function apply(Change $change)
    {
        $change->bill10 = 1;
    }

    /**
     * @return int
     */
    public function getModuloRest()
    {
        return 0;
    }
}