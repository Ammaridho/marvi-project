<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * This class will handle the decision whether we're going to skip a
 * day for delivery
 */
class OrderDateExclusionService
{
    /**
     * Currently we're excluding weekend (which is Sunday)
     * @param Carbon $date
     * @return bool
     */
    public function isDeliverDay(Carbon $date) {
        //other choice
        //return $date->isDayOfWeek(Carbon::SATURDAY) ||
        //    $date->isDayOfWeek(Carbon::SUNDAY)
        //;
        return $date->isWeekend();
    }

}
