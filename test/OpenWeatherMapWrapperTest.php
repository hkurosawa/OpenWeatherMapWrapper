<?php
require_once('/usr/lib/php/share/pear/PHPUnit/Framework/TestCase.php');
require_once('../src/OpenWeatherMapWrapper.class.php');

class OpenWeatherMapWrapperTest extends PHPUnit_Framework_TestCase {
    var $owm = null;
    
    public static function setUpBeforeClass() {
        //do nothing
    }
    
    public static function tearDownAfterClass() {
        //do nothing
    }
    
    public function setUp() {
        //do nothing
        $this->owm = new OpenWeatherMapWrapper();
    }
    
    public function tearDown() {
        //do nothing
    }
    
    public function testHello () {
        $this->assertEquals(100, 100);
    }
    
    public function test_search_city_by_coord () {
        $count = 5;
        $result = $this->owm->search_city_by_coord(135.77182, 35.004487, $count);
        $this->assertLessThanOrEqual($count, $result->{'count'});
    }
    
    public function test_search_city_by_name () {
        $count = 5;
        $result = $this->owm->search_city_by_name('Tokyo', $count);
        $this->assertLessThanOrEqual($count, $result->{'count'});
    }
    
    public function test_search_current_weather_by_cood () {
        $result = $this->owm->search_current_weather_by_cood(135.77182, 35.004487);
        $this->assertGreaterThanOrEqual(1, count($result->{'weather'}));
    }
    
    public function test_search_current_weather_by_city_id() {
        $result = $this->owm->search_current_weather_by_city_id(2643743);//London
        $this->assertEquals("London", $result->{'name'});        
    }

    public function test_search_history_by_city_id () {
        $result = $this->owm->search_history_by_city_id(2643743, 1389280469);//London, 2014-01-09 15:14:29
        $this->assertGreaterThanOrEqual(1, $result->{'cnt'});
    }
}
