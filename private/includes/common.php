<?
/*
* recursively remove empty array elements
* 
* @param: $array
* @return: trimmed $array
*/
function array_remove_empty($array) {
    if (!empty($array)) {
        foreach ($array as $key => $value) { 
            if (is_array($value)) {
                $array[$key] = array_remove_empty($array[$key]);
            }
            if ($array[$key] === false) {    
            } else {
                if (empty($array[$key])) {
                    unset($array[$key]);
                }
            }
        }   
    }
    
    return $array;
}

/*
* redirect to location
*
* @param $location: page url to redirect too
* @return: false if $location is not valid
*/
function redirect($location) {
    if (!empty($location)) header("Location: ".$location);
    return false;
}