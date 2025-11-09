<?php
namespace App\Forms\DataObjects;

use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Forms\MyConstraints\IsInt;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use App\Utils\StringTools;

trait AstromanIdTrait 
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new NotBlank(['message' => 'Zadejte číslo záznamu']));
        $metadata->addPropertyConstraint('id', new IsInt(['message' => 'Neplatný formát čísla záznamu']));
        $metadata->addGetterConstraint('astromanExists', new IsTrue(['message' => 'Záznam nenalezen']));
    }

    public function isAstromanExists(): bool
    {
        $stringTools = new StringTools;
        if (!$stringTools->isInt($this->id)) {
            return true; //není-li $id int, nutné to podchytit jiným constrainem
        }

        $model = $this->astromenModel;
        return $model->idExists($this->id);
    }
}
