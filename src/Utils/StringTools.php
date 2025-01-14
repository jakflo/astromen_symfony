<?php

namespace App\Utils;

class StringTools {
    public function isInt($value) {
        if (!is_numeric($value) || $value != intval($value)) {
            return false;
        }
        else {
            return true;
        }        
    }
}
