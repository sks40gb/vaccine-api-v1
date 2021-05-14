<?php

namespace Ziletech\Util;

use DateTime;
use DateTimeZone;
use Exception;

class DateUtil {

    /**
     * Alternate ISO 8601 format without fractional seconds
     */
    const ALTERNATE_ISO8601_DATE_FORMAT = "Y-m-d\TH:i:s.u\Z";

    /**
     * @var DateTimeZone The UTC timezone object.
     */
    public static $UTC_TIMEZONE;

    /**
     * Initialize $UTC_TIMEZONE
     */
    public static function __init() {
        DateUtil::$UTC_TIMEZONE = new DateTimeZone("UTC");
    }

    /**
     * 
     * @param DateTime $date
     * @return string
     */
    public static function getDayOfWeek(DateTime $date): string {
        return date('w', $date->getOffset());
    }

    /**
     * Parses the specified date string as an ISO 8601 date and returns the Date
     * object.
     *
     * @param $dateString string The date string to parse.
     * @return DateTime The parsed Date object.
     * @throws Exception If the date string could not be parsed.
     */
    public static function parseDate($dateString) {
        return DateTime::createFromFormat(DateUtil::ALTERNATE_ISO8601_DATE_FORMAT, $dateString, DateUtil::$UTC_TIMEZONE
        );
    }

    /**
     * Formats the specified date as an ISO 8601 string.
     *
     * @param $datetime \DateTime The date to format.
     * @return string The ISO 8601 string representing the specified date.
     */
    public static function formatDate($datetime) {
        return $datetime->format(DateUtil::ALTERNATE_ISO8601_DATE_FORMAT);
    }

    public static function getDaysDiff($startDate, $endDate) {
        $diff = date_diff($startDate, $endDate);
        return $diff->format("%a");
    }

    public static function getTimeDiff($startDate, $endDate) {
        $interval = $startDate->diff($endDate);
        if ($interval->h > 0) {
            $elapsed = $interval->format('%h hours');
        }
        if ($interval->i > 0) {
            $elapsed .= $interval->format(' %i minutes');
        }
        return $elapsed;
    }

    public static function addDays($date, int $days) {
        date_add($date, date_interval_create_from_date_string($days . " days"));
    }

    public static function getDateWithoutTime($date) {
        return new DateTime($date->format('Y-m-d'));
    }

    public static function getCurrentDate() {
        return new DateTime();
    }

    public static function getTomorrowDate(DateTime $date) {
        $newDate = clone $date;
        self::addDays($newDate, 1);
        return $newDate;
    }

}

DateUtil::__init();
