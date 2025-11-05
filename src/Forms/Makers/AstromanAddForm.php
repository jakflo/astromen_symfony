<?php

namespace App\Forms\Makers;
use Symfony\Component\Form\FormBuilderInterface;

class AstromanAddForm extends MakeAstromanCommon 
{
    use TAddButtons;
    
    public function buildForm(FormBuilderInterface $builder, array $options): void {
         parent::buildForm($builder, $options);
         $this->addButtons($builder, 'Přidat');
    }
}
