<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TimeZoneUtil
 *
 * @author Luis
 */
class TimeZoneUtil {

    public static function getAllTimeZones() {
        $timezones = DateTimeZone::listAbbreviations();

        $cities = array();
        foreach ($timezones as $key => $zones) {
            foreach ($zones as $id => $zone) {
                /**
                 * Only get timezones explicitely not part of "Others".
                 * @see http://www.php.net/manual/en/timezones.others.php
                 */
                if (preg_match('/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $zone['timezone_id']) && $zone['timezone_id']) {
                    $cities[$zone['timezone_id']][] = $key;
                }
            }
        }

        // For each city, have a comma separated list of all possible timezones for that city.
        foreach ($cities as $key => $value)
            $cities[$key] = join(', ', $value);

        // Only keep one city (the first and also most important) for each set of possibilities. 
        $cities = array_unique($cities);

        // Sort by area/city name.
        ksort($cities);
        return $cities;
    }

    public static function getAvaliableCities() {
        $timezones = self::getAllTimeZones();
        $cities = array();
        foreach($timezones as $k => $v){
            $cities[] = $k;
        }
        return $cities;
    }

}

?>
