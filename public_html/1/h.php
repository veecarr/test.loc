<?php
function search_str_all($filename, $key, $type){
    //echo "---search start---<br>";
    for ($i = 0; !feof($filename); $i++) {
        $str = explode('; ', fgets($filename, 4096));
        /*echo "str = $str_arr[0]; $str_arr[1]; $str_arr[2]; $str_arr[3]; $str_arr[4]<br>";
        echo "str finded = $str[$type]<br>";
        echo "type = $type<br>";
        echo "you search - $key<br>";*/
        if ($str[$type] === $key){
            //echo "return true<br>---search end---<br><br><br>";
            rewind($filename);
            return true;
        }
        else{
            //echo "$key not found<br><br>";
            continue;
        }
    }
    rewind($filename);
    return false;
    //echo "return false<br>---search end---<br><br>";
}

function search_str($filename, $key, $type){
    $search_flag = false;
    for ($i = 0; !feof($filename); $i++) {
        $str = fgets($filename, 4096);
        $str_add = explode('; ', $str);
        if ($str_add[$type] === $key){
            $search_flag = true;
        }
    }
    rewind($filename);
    if ($search_flag) {
        return true;
    }
    else{
        return false;
    }
}