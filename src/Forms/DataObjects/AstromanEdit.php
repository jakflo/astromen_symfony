<?php

namespace App\Forms\DataObjects;
use App\Entity\Models\Db_wrap;
use App\Entity\Models\AstromenModel;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Forms\MyConstraints\IsInt;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use App\Utils\StringTools;

class AstromanEdit extends AstromanAdd {
    protected $id;
    protected $db;
    
    public function __construct(Db_wrap $db) {
        $this->db = $db;
    }

    public function getId() {
    return $this->id;
    }

    public function setId($id) {
    $this->id = $id;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {        
        $metadata->addPropertyConstraint('id', new NotBlank(['message' => 'Zadejte číslo záznamu']));
        $metadata->addPropertyConstraint('id', new IsInt(['message' => 'Neplatný formát čísla záznamu']));
        $metadata->addGetterConstraint('astromanExists', new IsTrue(['message' => 'Záznam nenalezen']));
    }
    
    public function isAstromanExists() {
        $stringTools = new StringTools;
        if (!$stringTools->isInt($this->id)) {
            return true; //není-li $id int, nutné to podchytit jiným constrainem
        }
        $model = new AstromenModel($this->db);
        return $model->idExists($this->id);
    }
}
