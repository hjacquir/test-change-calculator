<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 18:18
 */

namespace AppBundle\Strategy;

/**
 * Class AmountModulo5RestMultipleOf2
 * @package AppBundle\Strategy
 */
class AmountModulo5RestMultipleOf2 extends SubjectStrategy
{
    /**
     * @var AmountIn5To10IntervallAndNotMultiple2
     */
    private $amountIn5To10IntervallAndNotMultiple2;

    /**
     * AmountModulo5RestMultipleOf2 constructor.
     * @param AmountIn5To10IntervallAndNotMultiple2 $amountIn5To10IntervallAndNotMultiple2
     */
    public function __construct(AmountIn5To10IntervallAndNotMultiple2 $amountIn5To10IntervallAndNotMultiple2)
    {
        $this->amountIn5To10IntervallAndNotMultiple2 = $amountIn5To10IntervallAndNotMultiple2;
    }

    /**
     * @return bool
     */
    public function isAppropriate()
    {
        return $this->getResult() !== 0 &&
            $this->multipleOf($this->getResult(), 2);
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->amountIn5To10IntervallAndNotMultiple2->getResult();
    }
}