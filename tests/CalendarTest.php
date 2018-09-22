<?php
/**
 * Created by PhpStorm.
 * User: das
 * Date: 22/09/2018
 * Time: 10:34 AM
 */

namespace Dasigr\Test;

use Dasigr\Calendar\Calendar;
use PHPUnit\Framework\TestCase;

/**
 * Class CalendarTest
 * @package Dasigr\Test
 */
class CalendarTest extends TestCase {

  /**
   * Test that getDay throws an Exception.
   */
  public function testGetDayThrowsException() {
    $calendar = new Calendar();
    
    // Maximum days in a month is either 21 or 22, depending if it's even or odd.
    $this->expectException(\Exception::class);
    
    $date = '23.01.1990';
    $day = $calendar->getDay($date);
  }
  
  /**
   * Test getting the day of a certain date.
   */
  public function testGetDay() {
    $calendar = new Calendar();

    // Assert first day of 1990 is Monday.
    $date = '01.01.1990';
    $day = $calendar->getDay($date);
    $this->assertEquals('Monday', $day, 'Expecting that the first day of 1990 is Monday.');
    
    // Assert that the 20th day of January 1990 is a Saturday.
    $date = '20.01.1990';
    $day = $calendar->getDay($date);
    $this->assertEquals('Saturday', $day, 'Expecting that the 20th day of January 1990 is a Saturday.');

    // Assert that the 10th day of February 1990 is a Thursday.
    $date = '10.02.1990';
    $day = $calendar->getDay($date);
    $this->assertEquals('Thursday', $day, 'Expecting that the 10th day of February 1990 is a Thursday.');

    // Assert that the 15th day of March 1990 is a Tuesday.
    $date = '15.03.1990';
    $day = $calendar->getDay($date);
    $this->assertEquals('Tuesday', $day, 'Expecting that the 15th day of March 1990 is a Tuesday.');

    // Assert that the 3rd day of April 1990 is a Friday.
    $date = '03.04.1990';
    $day = $calendar->getDay($date);
    $this->assertEquals('Friday', $day, 'Expecting that the 3rd day of April 1990 is a Friday.');
    
    // Assert that 17th day of November 2013 is a Friday.
    $date = '17.11.2013';
    $day = $calendar->getDay($date);
    $this->assertEquals('Friday', $day, 'Expecting that the 17th day of November 2013 is a Friday.');
  }

  /**
   * Test getting first day of the year.
   */
  public function testFirstDayOfTheYear() {
    $calendar = new Calendar();
    $day = $calendar->getFirstDayOfTheYear(1991);
    $this->assertEquals('Monday', $day, 'Expecting Monday as the first day of year 1991.');
  }

  /**
   * Test if it's a leap year.
   */
  public function testIsLeapYear() {
    $calendar = new Calendar();
    $this->assertTrue($calendar->isLeapYear(1993), 'Failed asserting that 1993 is a leap year.');
  }

  /**
   * Test getting number of past leap years.
   */
  public function testGetNumberOfPastLeapYears() {
    $calendar = new Calendar();
    $this->assertEquals(5, $calendar->getNumberOfPastLeapYears(2018));
  }

}