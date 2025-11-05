<?php

namespace App\Forms\Makers;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AstromanDeleteForm extends AbstractType 
{
    use TAddButtons;
    
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder->add('id', HiddenType::class);
        $this->addButtons($builder, 'Ano', 'Ne');
    }
}
