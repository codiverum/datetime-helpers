<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace codiverum\datetime;

use DateInterval;
use DateTime;

/**
 * Description of DateTimeHelper
 *
 * @author Jozek
 */
class DateTimeHelper
{

    /**
     * Adds years or months or days to $date
     * @param string $unit
     * @param integer $unitCount
     * @param mixed $date if null current date time will be used
     * @return DateTime
     */
    public static function addDateUnits($unit, $unitCount, $date = null)
    {
        /* @var $date DateTime */
        $resDate = new DateTime();
        if (!is_null($date))
            $resDate->setTimestamp($date);
        $specInterval = static::getDateSpecInterval($unit, $unitCount);
        $interval = new DateInterval($specInterval);
        $resDate->add($interval);
        return $resDate;
    }

    /**
     * 
     * @param integer $number number of days to add
     * @param DateTime $datetime
     * @return DateTime
     */
    public static function addDays($number, $datetime = null)
    {
        return static::add('D', $number, $datetime);
    }

    /**
     * 
     * @param integer $number number of months to add
     * @param DateTime $datetime
     * @return DateTime
     */
    public static function addMonths($number, $datetime = null)
    {
        return static::add('M', $number, $datetime);
    }

    /**
     * 
     * @param integer $number number of years to add
     * @param DateTime $datetime
     * @return DateTime
     */
    public static function addYears($number, $datetime = null)
    {
        return static::add('Y', $number, $datetime);
    }

    /**
     * Method checks whether datetimes is in the same month and returns month only (!) difference 
     *
     * @param DateTime $date1
     * @param DateTime $date2
     * @return int
     */
    public static function getMonthOnlyDiff(DateTime $date1, DateTime $date2)
    {
        if (empty($date2))
            return null;
        $date1->setDate($date1->format('Y'), $date1->format('n'), 1);
        $date1->setTime(0, 0, 0);
        $date2->setTime(0, 0, 0);
        $date2->setDate($date2->format('Y'), $date2->format('n'), 1);
        $diff = $date1->diff($date2);
        $years = $diff->format('%y');
        $months = $diff->format('%m');
        $totalMonths = $years * 12 + $months;
        return $totalMonths;
    }

    /**
     * 
     * @param DateTime $date1
     * @param DateTime $date2
     * @return integer number of days between
     */
    public static function getDaysBetween(DateTime $date1, DateTime $date2)
    {
        $date1->setTime(0, 0, 0);
        $date2->setTime(0, 0, 0);
        return $date1->diff($date2)->format('%a');
    }

    /**
     * @param integer $monthNumber [1-12]
     * @return DateTime
     */
    public static function getFirstMonthDate($monthNumber)
    {
        $dt = new DateTime();
        $dt->setDate(date('Y'), $monthNumber, 1);
        return $dt;
    }

    protected static function add($unit, $unitCount, $dt = null)
    {
        if (empty($dt))
            $dt = new DateTime();
        $interval = new DateInterval(static::getDateSpecInterval($unit, $unitCount));
        $dt->add($interval);
        return $dt;
    }

    /**
     * Gets interval
     * @param string $unit
     * @param integer $unitCount
     * @return string
     */
    protected static function getDateSpecInterval($unit, $unitCount)
    {
        return "P" . $unitCount . $unit;
    }

}
