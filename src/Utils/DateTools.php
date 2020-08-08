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
    
    public function czDateToEn(string $czDate) {
        $czDateArray = explode('.', $czDate);
        $enDate = "{$czDateArray[2]}-{$czDateArray[1]}-{$czDateArray[0]}";
        return date('Y-m-d', strtotime($enDate));
    }
    
    public function checkEnDate(string $date) {
        $dateArr = explode('-', $date);
        if (count($dateArr) !== 3) {
            return false;
        }
        return checkdate($dateArr[1], $dateArr[2], $dateArr[0]);
    }
    
    public function checkCzDate(string $date) {
        $dateArr = explode('.', $date);
        if (count($dateArr) !== 3) {
            return false;
        }
        return checkdate($dateArr[1], $dateArr[0], $dateArr[2]);
    }
}
