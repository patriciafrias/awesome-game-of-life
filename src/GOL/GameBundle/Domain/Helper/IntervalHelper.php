<?php

declare(strict_types=1);

namespace GOL\GameBundle\Domain\Helper;

class LifeIntervalHelper
{
    /**
     * Set interval for a given function.
     * @param null $func
     * @param int $interval
     * @param int $times
     */
    function setLifeInterval($func = null, $interval = 0, $times = 0)
    {
        if (($func == null) || (!function_exists($func))) {
            throw new Exception('Invalid function.');
        }

        $seconds = $interval * 1000;

        // If $times > 0, we will execute it a limited times, otherwise, we until abort the script.
        if ($times > 0) {
            $i = 0;
            while ($i < $times) {
                call_user_func($func);
                $i++;
                usleep($seconds);
            }
        } else {
            while (true) {
                call_user_func($func); // Call a defined function.
                usleep($seconds);
            }
        }
    }
}
