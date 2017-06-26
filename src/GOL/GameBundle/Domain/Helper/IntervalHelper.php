<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain\Helper;

/**
 * Class IntervalHelper
 * @package GOL\GameBundle\Domain\Helper
 */
class IntervalHelper
{
    /**
     * Set interval for a given function.
     * @param null $function
     * @param int $interval
     * @param int $times
     */
    function setInterval($function = null, $interval = 0, $times = 0)
    {
        if (($function == null) || (!function_exists($function))) {
            throw new Exception('Invalid function.');
        }

        $seconds = $interval * 1000;

        // If $times > 0, we will execute it a limited times, otherwise, we until abort the script.
        if ($times > 0) {
            $i = 0;
            while ($i < $times) {
                call_user_func($function);
                $i++;
                usleep($seconds);
            }
        } else {
            while (true) {
                call_user_func($function); // Call a defined function.
                usleep($seconds);
            }
        }
    }
}
