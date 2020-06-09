<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 09/06/2020
 * Time: 13:44
 */

namespace AppBundle\Calculator;

use AppBundle\Model\Change;

/**
 * Class Mk2Calculator
 * @package AppBundle\Calculator
 */
class Mk2Calculator implements CalculatorInterface
{
    const OPERATION_IMPOSSIBLE = -1;

    /**
     * @var Change
     */
    private $change;

    /**
     * @var array
     * @todo ecapsulate in object and inject
     */
    private $coin2Collector = [];

    /**
     * @var array
     * @todo ecapsulate in object and inject
     */
    private $bill5Collector = [];

    /**
     * @var array
     * @todo ecapsulate in object and inject
     */
    private $bill10Collector = [];

    /**
     * Mk2Calculator constructor.
     * @param Change $change
     */
    public function __construct(Change $change)
    {
        $this->change = $change;
    }

    /**
     * @return string Indicates the model of automaton
     */
    public function getSupportedModel(): string
    {
        return CalculatorInterface::MK2_MODEL;
    }

    /**
     * @param int $amount The amount of money to turn into change
     *
     * @return Change|null The change, or null if the operation is impossible
     */
    public function getChange(int $amount): ?Change
    {
        $this->collectCoin2($amount);
        $this->collectBill5($amount);
        $this->collectBill10($amount);

        if (in_array(self::OPERATION_IMPOSSIBLE, $this->coin2Collector)) {
            return null;
        }

        $this->change->coin2 = array_sum($this->coin2Collector);
        $this->change->bill5 = array_sum($this->bill5Collector);
        $this->change->bill10 = array_sum($this->bill10Collector);

        return $this->change;
    }

    /**
     * @param int $number
     * @param int $multipleOf
     * @return bool
     * @todo ecapsulate in object and inject
     */
    private function multipleOf(int $number, int $multipleOf)
    {
        return $number % $multipleOf === 0;
    }

    /**
     * @param int $amount
     * @todo encapsulate
     */
    private function collectCoin2(int $amount)
    {
        $current = 0;

        $impossible = self::OPERATION_IMPOSSIBLE;

        if ($amount < 5) {
            $current = intdiv($amount, 2);

            if (false === $this->multipleOf($amount, 2)) {
                $current = $impossible;
            }
        }

        array_push($this->coin2Collector, $current);
    }

    /**
     * @param int $amount
     * @todo encapsulate
     */
    private function collectBill5(int $amount)
    {
        $current = 0;

        if ($amount === 5) {
            $current = 1;
        }

        if ($amount > 5 && $amount < 10) {

            if (true === $this->multipleOf($amount, 2)) {
                $coin2 = intdiv($amount, 2);
                array_push($this->coin2Collector, $coin2);
            } else {
                $result = $amount % 5;
                $current = intdiv($amount, 5);

                if (true === $this->multipleOf($result, 2)) {
                    $this->collectCoin2($result);
                }
            }
        }

        array_push($this->bill5Collector, $current);
    }

    /**
     * @param int $amount
     * @todo encapsulate
     */
    private function collectBill10(int $amount)
    {
        $current = 0;

        if ($amount === 10) {
            $current = 1;
        }

        if ($amount > 10) {
            $result = $amount % 10;
            $current = intdiv($amount, 10);

            if ($result !== 0) {
                $this->collectCoin2($result);
                $this->collectBill5($result);
            }
        }

        array_push($this->bill10Collector, $current);
    }
}