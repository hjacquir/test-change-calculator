<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 18:00
 */

namespace AppBundle\Strategy;

use AppBundle\Model\Change;
use SplObserver;

/**
 * Class SubjectStrategy
 * @package AppBundle\Strategy
 */
abstract class SubjectStrategy implements Strategy, \SplSubject
{
    /**
     * @var SplObserver[]
     */
    private $observers = [];

    /**
     * @var Change
     */
    private $change;

    /**
     * @param Change $change
     * @return void
     */
    public function apply(Change $change)
    {
        $this->change = $change;
        $this->notify();
    }

    /**
     * @return Change
     */
    public function getChange(): Change
    {
        return $this->change;
    }

    /**
     * Attach an SplObserver
     * @link https://php.net/manual/en/splsubject.attach.php
     * @param SplObserver $observer <p>
     * The <b>SplObserver</b> to attach.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function attach(SplObserver $observer)
    {
        array_push($this->observers, $observer);
    }

    /**
     * Detach an observer
     * @link https://php.net/manual/en/splsubject.detach.php
     * @param SplObserver $observer <p>
     * The <b>SplObserver</b> to detach.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function detach(SplObserver $observer)
    {
        // TODO: Implement detach() method.
    }

    /**
     * Notify an observer
     * @link https://php.net/manual/en/splsubject.notify.php
     * @return void
     * @since 5.1.0
     */
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
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
}