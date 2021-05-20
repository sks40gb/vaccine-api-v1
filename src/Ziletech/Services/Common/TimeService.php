<?php

namespace Ziletech\Services\Common;

class TimeService {

    public static function getDiffInSeconds($from, $to) {
        $diff = $to->diff($from);
        $daysInSecs = $diff->format('%r%a') * 24 * 60 * 60;
        $hoursInSecs = $diff->h * 60 * 60;
        $minsInSecs = $diff->i * 60;
        $seconds = $daysInSecs + $hoursInSecs + $minsInSecs + $diff->s;
        return $seconds;
    }

    public static function getDateForDatabase(string $date): string {
        $timestamp = strtotime($date);
        $date_formated = date('Y-m-d H:i:s', $timestamp);
        return $date_formated;
    }

}
