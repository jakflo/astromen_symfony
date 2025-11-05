<?php

namespace App\Forms\Makers;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AstromanEditForm extends MakeAstromanCommon 
{
    use TAddButtons;
    
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder->add('id', HiddenType::class, ['label' => 'id']);
        parent::buildForm($builder, $options);
        $this->addButtons($builder, 'Uložit');
    }
}
