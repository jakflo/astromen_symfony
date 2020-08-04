<?php

namespace App\Forms\DataObjects;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Forms\MyConstraints\CzDate;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class AstromanAdd {
    protected $fName;
    protected $lName;
    protected $dob;
    protected $skill;

    public function getFName() {
    return $this->fName;
    }
    public function getLName() {
    return $this->lName;
    }
    public function getDob() {
    return $this->dob;
    }
    public function getSkill() {
    return $this->skill;
    }

    public function setFName($fName) {
    $this->fName = $fName;
    }
    public function setLName($lName) {
    $this->lName = $lName;
    }
    public function setDob($dob) {
    $this->dob = $dob;
    }
    public function setSkill($skill) {
    $this->skill = $skill;
    }
    
     public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('fName', new NotBlank(['message' => 'Zadejte jméno']));
        $metadata->addPropertyConstraint('lName', new NotBlank(['message' => 'Zadejte příjmení']));
        $metadata->addPropertyConstraint('dob', new NotBlank(['message' => 'Zadejte datum narození']));
        $metadata->addPropertyConstraint('dob', new CzDate(['message' => 'Neplatné datum narození']));
        $metadata->addPropertyConstraint('skill', new NotBlank(['message' => 'Zadejte dovednost']));
    }
}
