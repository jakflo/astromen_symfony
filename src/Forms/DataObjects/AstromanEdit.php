<?php

namespace App\Forms\DataObjects;
use App\Utils\DateTools;

class AstromanEdit extends AstromanAdd {
    use AstromanIdTrait;
    
    public function isNameNotUsedYet() {
        $dateTools = new DateTools;
        if (empty($this->fName) or empty($this->lName) or empty($this->dob)) {
            return true;
        }
        $model = $this->astromen_model;
        return !$model->isNameExists($this->fName, $this->lName, $this->dob, $this->id);        
    }
}
