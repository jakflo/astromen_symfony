<?php

namespace App\Forms\DataObjects;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use App\Forms\MyConstraints\CzDate;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use App\Utils\DateTools;

class AstromanAdd 
{
    protected $fName;
    protected $lName;
    protected $dob;
    protected $skill;
    
    public function __construct(
            protected \App\Models\AstromenModel $astromen_model
    )
    {
        
    }

    public function getFName()
    {
        return $this->fName;
    }

    public function getLName()
    {
        return $this->lName;
    }

    public function getDob()
    {
        return $this->dob;
    }

    public function getSkill()
    {
        return $this->skill;
    }

    public function setFName($fName)
    {
        $this->fName = $fName;
    }

    public function setLName($lName)
    {
        $this->lName = $lName;
    }

    public function setDob($dob)
    {
        $this->dob = $dob;
    }

    public function setSkill($skill)
    {
        $this->skill = $skill;
    }

    public function getFullName()
    {
        return trim("{$this->fName} {$this->lName}");
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('fName', new NotBlank(['message' => 'Zadejte jméno']));
        $metadata->addPropertyConstraint('fName', new Length(['max' => 20, 'maxMessage' => 'Jméno může mít nanejvýš 20 znaků']));
        $metadata->addPropertyConstraint('lName', new NotBlank(['message' => 'Zadejte příjmení']));
        $metadata->addPropertyConstraint('lName', new Length(['max' => 20, 'maxMessage' => 'Příjmení může mít nanejvýš 20 znaků']));
        $metadata->addPropertyConstraint('dob', new NotBlank(['message' => 'Zadejte datum narození']));
        $metadata->addPropertyConstraint('skill', new NotBlank(['message' => 'Zadejte dovednost']));
        $metadata->addPropertyConstraint('skill', new Length(['max' => 45, 'maxMessage' => 'Dovednost může mít nanejvýš 45 znaků']));
        $metadata->addGetterConstraint('nameNotUsedYet', new IsTrue(['message' => 'Tento astronaut již existuje']));
    }
    
    public function isNameNotUsedYet() {
        if (empty($this->fName) || empty($this->lName) || empty($this->dob)) {
            return true;
        }
        
        $model = $this->astromen_model;
        return !$model->isNameExists($this->fName, $this->lName, $this->dob);        
    }
}
