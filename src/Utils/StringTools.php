<?php

namespace App\Utils;

class StringTools {
    public function isInt($value) {
        if (!is_numeric($value) or $value != intval($value)) {
            return false;
        }
        else {
            return true;
        }        
    }
}
