<?php

namespace App\Forms\DataObjects;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use App\Forms\MyConstraints\CzDate;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use App\Entity\Models\AstromenModel;
use App\Entity\Models\Db_wrap;
use App\Utils\DateTools;

class AstromanAdd {
    protected $fName;
    protected $lName;
    protected $dob;
    protected $skill;
    
    /**
     *
     * @var Db_wrap
     */
    protected $db;
    
    public function __construct(Db_wrap $db) {
        $this->db = $db;
    }

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
        $metadata->addPropertyConstraint('fName', new Length(['max' => 20, 'maxMessage' => 'Jméno může mít nanejvýš 20 znaků']));
        $metadata->addPropertyConstraint('lName', new NotBlank(['message' => 'Zadejte příjmení']));
        $metadata->addPropertyConstraint('lName', new Length(['max' => 20, 'maxMessage' => 'Příjmení může mít nanejvýš 20 znaků']));
        $metadata->addPropertyConstraint('dob', new NotBlank(['message' => 'Zadejte datum narození']));
        $metadata->addPropertyConstraint('dob', new CzDate(['message' => 'Neplatné datum narození']));
        $metadata->addPropertyConstraint('skill', new NotBlank(['message' => 'Zadejte dovednost']));
        $metadata->addPropertyConstraint('skill', new Length(['max' => 45, 'maxMessage' => 'Dovednost může mít nanejvýš 45 znaků']));
        $metadata->addGetterConstraint('nameNotUsedYet', new IsTrue(['message' => 'Tento astronaut již existuje']));
    }
    
    public function isNameNotUsedYet() {
        $dateTools = new DateTools;
        if (empty($this->fName) or empty($this->lName) or empty($this->dob) or !$dateTools->checkCzDate($this->dob)) {
            return true;
        }
        $model = new AstromenModel($this->db);
        return !$model->isNameExists($this->fName, $this->lName, $this->dob);        
    }
}
