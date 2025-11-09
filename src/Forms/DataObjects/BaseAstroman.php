<?php

namespace App\Forms\DataObjects;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Mapping\ClassMetadata;

abstract class BaseAstroman
{
    const maxFNameLength = 20;
    const maxLNameLength = 20;
    const maxSkillLength = 45;

    protected string $fName;
    protected string $lName;
    protected \DateTime $dob;
    protected string $skill;
    
    public function getFName(): string
    {
        return $this->fName;
    }

    public function getLName(): string
    {
        return $this->lName;
    }

    public function getDob(): \DateTime
    {
        return $this->dob;
    }

    public function getSkill(): string
    {
        return $this->skill;
    }

    public function setFName(string $fName)
    {
        $this->fName = $fName;
    }

    public function setLName(string $lName)
    {
        $this->lName = $lName;
    }

    public function setDob(\DateTime $dob)
    {
        $this->dob = $dob;
    }

    public function setSkill(string $skill)
    {
        $this->skill = $skill;
    }

    public function getFullName(): string
    {
        return trim("{$this->fName} {$this->lName}");
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('fName', new NotBlank(['message' => 'Zadejte jméno']));
        $metadata->addPropertyConstraint('fName', new Length(['max' => self::maxFNameLength, 'maxMessage' => 'Jméno může mít nanejvýš ' . self::maxFNameLength . ' znaků']));
        $metadata->addPropertyConstraint('lName', new NotBlank(['message' => 'Zadejte příjmení']));
        $metadata->addPropertyConstraint('lName', new Length(['max' => self::maxLNameLength, 'maxMessage' => 'Příjmení může mít nanejvýš ' . self::maxLNameLength . ' znaků']));
        $metadata->addPropertyConstraint('dob', new NotBlank(['message' => 'Zadejte datum narození']));
        $metadata->addPropertyConstraint('skill', new NotBlank(['message' => 'Zadejte dovednost']));
        $metadata->addPropertyConstraint('skill', new Length(['max' => self::maxSkillLength, 'maxMessage' => 'Dovednost může mít nanejvýš ' . self::maxSkillLength . ' znaků']));
    }
    
}
