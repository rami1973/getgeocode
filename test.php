<?php
function GetGeocode($lat, $lng, $lang)
{
    //put your key or use env
    $key = env('GOOGLE_MAPS_API_KEY');
    
    //dd($key);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false&language=$lang&key=$key";

    $json = file_get_contents($url);
    $obj = json_decode($json);
    $results = $obj->results;
    if ($results[1]) {
        $country = null;
        $countryCode = null;
        $city = null;
        $cityAlt = null;

        for ($r = 0; $r < count($results); $r++) {
            $result = $results[$r];
            if (!$city && $result->types[0] === 'locality') {
                for ($c = 0; $c < count($result->address_components); $c++) {

                    $component = $result->address_components[$c];

                    if ($component->types[0] === 'locality') {
                        $city = $component->long_name;
                        break;
                    }
                    if ($component->types[0] === "administrative_area_level_2") {
                        $city = $component->long_name;
                        break;
                    }
                    if ($component->types[0] === "administrative_area_level_1") {
                        $city = $component->long_name;
                        break;
                    }
                }
            } else if (!$city && !$cityAlt && $result->types[0] === 'plus_code') {
                for ($c = 0; $c < count($result->address_components); $c++) {
                    $component = $result->address_components[$c];

                    if ($component->types[0] === 'locality') {
                        $city = $component->long_name;
                        break;
                    }
                    if ($component->types[0] === "administrative_area_level_2") {
                        $city = $component->long_name;
                        break;
                    }
                    if ($component->types[0] === "administrative_area_level_1") {
                        $city = $component->long_name;
                        break;
                    }
                }
            } else if (!$city && !$cityAlt && $result->types[0] === 'administrative_area_level_2') {
                for ($c = 0; $c < count($result->address_components); $c++) {
                    $component = $result->address_components[$c];

                    if ($component->types[0] === 'locality') {
                        $city = $component->long_name;
                        break;
                    }
                    if ($component->types[0] === "administrative_area_level_2") {
                        $city = $component->long_name;
                        break;
                    }
                    if ($component->types[0] === "administrative_area_level_1") {
                        $city = $component->long_name;
                        break;
                    }
                }
            } else if (!$city && !$cityAlt && $result->types[0] === 'administrative_area_level_1') {
                for ($c = 0; $c < count($result->address_components); $c++) {
                    $component = $result->address_components[$c];

                    if ($component->types[0] === 'locality') {
                        $city = $component->long_name;
                        break;
                    }
                    if ($component->types[0] === "administrative_area_level_2") {
                        $city = $component->long_name;
                        break;
                    }
                    if ($component->types[0] === "administrative_area_level_1") {
                        $city = $component->long_name;
                        break;
                    }
                }
            } else if (!$country && $result->types[0] === 'country') {
                $country = $result->address_components[0]->long_name;
                $countryCode = $result->address_components[0]->short_name;
            }

            if ($city && $country) {
                break;
            }
        }

        echo "City: $city   City2:  $cityAlt   Country:  $country   Country Code: $countryCode\n";
    }
    $ret = [];
    $ret['city'] = $city;
    $ret['country'] = $country;
    $ret['countryCode'] = $countryCode;
    //echo $ret['city'];

    //print_r($obj);
    return ($ret);
}
?>