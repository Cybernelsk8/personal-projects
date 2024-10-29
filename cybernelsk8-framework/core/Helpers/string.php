<?php

function snake_case(string $str) : string {
    $snake_cased = [];
    $skip = [' ','-','_','/','\\','|',',','.',';',':'];
    $i = 0;
    while ($i < strlen($str)) {
        $last = count($snake_cased) > 0 ? $snake_cased[count($snake_cased) - 1] : null;
        $character = $str[$i++];
        if(ctype_upper($character)){
            if($last !== '_') {
                $snake_cased[] = '_';
            }
            $snake_cased[] = strtolower($character);
        } else if(ctype_lower($character)) {
            $snake_cased[] = $character;
        } else if(in_array($character,$skip)) {
            if($last !== '_'){
                $snake_cased[] = '_';
            }
            while($i < strlen($str) && in_array($str[$i], $skip)) {
                $i++;
            }
        }
    }

    if($snake_cased[0] == '_'){
        $snake_cased[0] = '';
    }

    if($snake_cased[count($snake_cased) - 1] == '_'){
        $snake_cased[count($snake_cased) - 1] = '';
    }

    return implode($snake_cased);
}