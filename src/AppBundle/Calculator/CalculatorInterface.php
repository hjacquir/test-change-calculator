<?php

declare(strict_types=1);

namespace AppBundle\Calculator;

use AppBundle\Model\Change;

interface CalculatorInterface
{
    const MK1_MODEL = 'mk1';
    const MK2_MODEL = 'mk2';

    /**
     * @return string Indicates the model of automaton
     */
    public function getSupportedModel(): string;

    /**
     * @param int $amount The amount of money to turn into change
     *
     * @return Change|null The change, or null if the operation is impossible
     */
    public function getChange(int $amount): ?Change;
}
