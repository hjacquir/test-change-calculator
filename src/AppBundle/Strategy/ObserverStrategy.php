<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 18:33
 */

namespace AppBundle\Strategy;

use SplSubject;

/**
 * Class ObserverStrategy
 * @package AppBundle\Strategy
 */
abstract class ObserverStrategy implements Strategy, \SplObserver
{
    /**
     * @var int
     */
    private $amount = 0;

    /**
     * AmountIn5To10IntervallAndMultiple2 constructor.
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @param int $amount
     */
    private function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $number
     * @param int $multipleOf
     * @todo encapsulate
     * @return bool
     */
    protected function multipleOf($number, int $multipleOf)
    {
        return $number % $multipleOf === 0;
    }

    /**
     * Receive update from subject
     * @link https://php.net/manual/en/splobserver.update.php
     * @param SplSubject $subject <p>
     * The <b>SplSubject</b> notifying the observer of an update.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function update(SplSubject $subject)
    {
        // we save temprary the initial amount
        $previousAmount = $this->getAmount();
        // if observer strategy is called by the subject we have to set the amount before calling isAppropriate()
        $this->setAmount($subject->getResult());

        if ($this->isAppropriate()) {
            $this->apply($subject->getChange());
        }

        // after class was called on the subject context we set the amount to his previous value
        $this->setAmount($previousAmount);
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return 0;
    }
}