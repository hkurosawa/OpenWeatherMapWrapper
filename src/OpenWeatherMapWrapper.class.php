<?php
require_once(dirname(__FILE__).'/constants.inc.php');
require_once(dirname(__FILE__).'/lib_http.php');

class OpenWeatherMapWrapper {
    private static $DIRECTION = array('N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW');
    private $key = null;

    /**
     * Constructor
     * @param $key OpenWeatherMap API Key, can be obtained from http://openweathermap.org/appid 
     */
    function __construct($key=null) {
        $this -> key = $key;
    }

    /**
     * Destructor
     */
    function __destruct() {
        // do nothing
    }

    /**
     * Search city from coodinates
     * http://bugs.openweathermap.org/projects/api/wiki/Api_2_5_searhing
     * @param $long longitude
     * @param $lat latitude
     * @param $cnt limit the number of cities to be listed
     * @param $type search accuracy. "accurate" or "like"
     * @param $mode out put format. "json" or "xml"
     * @param $units metric system "metric" or "imperial"
     *
     * @return JSON object
     */
    public function search_city_by_coord($lon, $lat, $cnt = 1, $type = 'accurtate', $mode = 'json', $units = 'metric') {
        // build req header
        $header = array();
        if (!is_null($this->key)) {
            $header['x-api-key'] = $this->key;
        }
        // build req body
        $body = array();
        $body['lat'] = $lat;
        $body['lon'] = $lon;
        $body['cnt'] = $cnt;
        $body['type'] = $type;
        $body['mode'] = $mode;
        $body['units'] = $units;
        
        // execute request
        $city_res = execute_http(URL_SEARCH_CITY, 'GET', $header, $body);
        $city_json = json_decode($city_res);
        
        return $city_json;
    }

    /**
     * search city from its name
     * http://bugs.openweathermap.org/projects/api/wiki/Api_2_5_searhing
     * @param $long longitude
     * @param $lat latitude
     * @param $cnt limit the number of cities to be listed
     * @param $type search accuracy. "accurate" or "like"
     * @param $mode out put format. "json" or "xml"
     * @param $units metric system "metric" or "imperial"
     *
     * @return JSON object
     */
    public function search_city_by_name($name, $cnt = 1, $type = 'like', $mode = 'json', $units = 'internal') {
        // build req header
        $header = array();
        if (!is_null($this->key)) {
            $header['x-api-key'] = $this->key;
        }
        // build req body
        $body = array();
        $body['q'] = $name;
        $body['cnt'] = $cnt;
        $body['type'] = $type;
        $body['mode'] = $mode;
        $body['units'] = $units;
        
        // execute request
        $city_res = execute_http(URL_SEARCH_CITY, 'GET', $header, $body);
        $city_json = json_decode($city_res);
        
        return $city_json;
    }

    /**
     * Get latest weather data from coodinates
     */
    function search_current_weather_by_cood($long, $lat) {
        $weather = execute_http(URL_CURRENT_WEATHER, 'GET', array(), array('lat' => $lat, 'lon' => $long));
        $weather_json = json_decode($weather);
        return $weather_json;
    }

    /**
     * Get latest weather data from station_id
     */
    function search_current_weather_by_city_id($id) {
        $weather = execute_http(URL_CURRENT_WEATHER, 'GET', array(), array('id' => $id));
        $weather_json = json_decode($weather);
        return $weather_json;
    }

    /**
     * @param start_time unix time UTC
     * @param end_time unix time UTC
     * @param type tick|hours|days
     * @param cnt
     */
    function search_history_by_city_id($id, $start_time, $end_time = null, $type = 'hour', $cnt = null) {
        $header = array();
        if (!is_null($this->key)) {
            $header['x-api-key'] = $this->key;
        }
        $weather_res = execute_http(URL_HISTORY, 'GET', $header, array('id' => $id, 'type' => 'hour', 'start' => $start_time));
        $weather_json = json_decode($weather_res);
        return $weather_json;
    }

    function degree_to_direction($degree) {
        return self::$DIRECTION[round($degree / 22.5)];
    }

    function kelvin_to_celsius($kelvin) {
        return $kelvin - 272.15;
    }
     
    function celsius_to_kelvin($celsius) {
        return $celsius + 272.15;
    }
}
