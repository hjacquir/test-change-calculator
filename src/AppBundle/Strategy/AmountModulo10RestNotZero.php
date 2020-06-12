<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 18:00
 */

namespace AppBundle\Strategy;

/**
 * Class AmountModulo10RestNotZero
 * @package AppBundle\Strategy
 */
class AmountModulo10RestNotZero extends SubjectStrategy
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
        return $this->getModuloRest() !== 0
            && false === in_array($this->getModuloRest(), [1,3]);
    }

    /**
     * @return int
     */
    public function getModuloRest()
    {
        return $this->amountSuperior10Strategy->getModuloRest();
    }
}