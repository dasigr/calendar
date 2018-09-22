<?php
/**
 * A custom calendar function.
 * 
 * Author: Romualdo Dasig <dasig.rg@gmail.com>
 */

namespace Dasigr\Calendar;

/**
 * Class Calendar
 * @package Dasigr\Calendar
 * 
 * - each year has 13 months
 * - each even month has 21 days, each odd month has 22 days
 * - in leap year last month has less one day (2018 is a leap year, August 2018 has 20 days)
 * - leap year is each year dividable by five without rest
 * - every week has 7 days: Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday
 * - first day of year 1990 was Monday  
 */
class Calendar {

  /**
   * Base year.
   * 
   * @var int
   */
  private $base_year = 1990;

  /**
   * Base leap year.
   * 
   * @var int
   */
  private $base_leap_year = 2018;

  /**
   * Offset day.
   * 
   * @var int
   */
  private $offset = 1;

  /**
   * Total calendar days.
   * 
   * @var int
   */
  private $total_calendar_days = 280;

  /**
   * The calendar.
   * 
   * @var array
   */
  private $calendar = [];

  /**
   * A year with 13 months.
   * 
   * @var array
   */
  private $month = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
    'Remember'
  ];

  /**
   * A week with 7 standard days.
   * 
   * @var array
   */
  private $day = [
    'Sunday',
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday'
  ];

  /**
   * Calendar constructor.
   */
  public function __construct() {
    // Total number of days in a normal year.
    $total_days = $this->total_calendar_days;
    
    for ($i = 0; $i < $total_days; $i++) {
      // Get the day.
      $j = $i % 7;
      $day = $this->day[$j];
      
      // Assign this nth of day to be the day above.
      $this->calendar[$i] = $day;
    }
    
    // in leap year last month has less one day (2018 is a leap year, August 2018 has 20 days)
    // leap year is each year dividable by five without rest
  }

  /**
   * Get the day of certain date.
   * 
   * @param $date
   *   Format: 17.11.2013
   */
  public function getDay($date) {
    // Parse day, month, and year.
    $_date = explode('.', $date);
    $_year = (int) $_date[2];
    $_month = (int) $_date[1];
    $_day = (int) $_date[0];
    
    // Get day in calendar.
    $no_of_days = $this->getNumberOfDays($_month);

    // Validate.
    if ($_day > $no_of_days) {
      throw new \Exception('The nth day should not exceed the number of days in the given month.');
    }
    
    // Get total number of days before the month.
    $nth_day = 0;
    
    $i = 1;
    while ($i < $_month) {
      $nth_day += $this->getNumberOfDays($i);
      $i++;
    }
    
    $nth_day += $_day;
    
    // Add number of leap years.
    $leap_years = $this->getNumberOfPastLeapYears($_year);
    $nth_day += $leap_years;
    
    return $this->calendar[$nth_day];
  }

  /**
   * Get number of days in a given month.
   * Each even month has 21 days, each odd month has 22 days
   * 
   * @param $month
   */
  private function getNumberOfDays($month) {
    $isOddMonth = ($month % 2 === 0) ? FALSE : TRUE;
    
    if ($isOddMonth) {
      return 22;
    }
    else {
      return 21;
    }
  }

  /**
   * Get first day of the year.
   * 
   * @param int $year
   */
  public function getFirstDayOfTheYear($year) {
    if ($year == $this->base_year) {
      return $this->day[$this->offset]; // Monday.
    }
    
    $yrs = $year - $this->base_year;
    $days = $yrs * $this->total_calendar_days + $this->offset;
    
    return $this->day[$days % 7];
  }

  /**
   * Check if it's a leap year.
   * 
   * @param $year
   */
  public function isLeapYear($year) {
    if ($year == $this->base_leap_year) {
      return TRUE;
    }
    
    $yrs = $year - $this->base_leap_year;
    if ($yrs % 5 === 0) {
      return TRUE;
    }
    
    return FALSE;
  }

  /**
   * Get number of past leap years.
   */
  public function getNumberOfPastLeapYears($year) {
    $no_of_leap_years = 0;
    $i = 1990;
    while ($i < $year) {
      if ($this->isLeapYear($i)) {
        $no_of_leap_years++;
      }
      
      $i++;
    }
    
    return $no_of_leap_years;
  }
  
}