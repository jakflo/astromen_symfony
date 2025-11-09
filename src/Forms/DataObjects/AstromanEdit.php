<?php

namespace App\Forms\DataObjects;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\IsTrue;

class AstromanEdit extends BaseAstroman
{
    use AstromanIdTrait;
    
    public function __construct(
            protected \App\Models\AstromenModel $astromenModel
    )
    {
        
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addGetterConstraint('nameNotUsedYet', new IsTrue(['message' => 'Tento astronaut již existuje']));
    }
    
    public function isNameNotUsedYet(): bool
    {
        if (empty($this->fName) || empty($this->lName) || empty($this->dob)) {
            return true;
        }
        $model = $this->astromenModel;
        return !$model->isNameExists($this->fName, $this->lName, $this->dob, $this->id);        
    }
    
}
