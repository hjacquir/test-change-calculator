<?php
/**
 * Created by PhpStorm.
 * User: h.jacquir
 * Date: 10/06/2020
 * Time: 17:23
 */

namespace AppBundle\Strategy;

use AppBundle\Model\Change;

/**
 * Interface Strategy
 * @package AppBundle\Strategy
 */
interface Strategy
{
    /**
     * @return bool
     */
    public function isAppropriate();

    /**
     * @param Change $change
     */
    public function apply(Change $change);

    /**
     * @return int
     */
    public function getResult();
}