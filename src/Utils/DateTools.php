<?php

namespace App\Utils;

class DateTools {
    public function enDateToCz(string $enDate, bool $withoutYear = false) {
        $date = strtotime($enDate);
        $format = $withoutYear? 'd.m.':'d.m.Y';
        return date($format, $date);
    }
    
    public function enDatetimeToCz(string $enDate, bool $withoutYear = false) {
        $enDate = trim($enDate);
        $enDateArr = explode(' ', $enDate);
        $date = $this->enDateToCz($enDateArr[0], $withoutYear);
        return "{$date} {$enDateArr[1]}";
    }
}
