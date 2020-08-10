<?php

namespace App\Forms\DataObjects;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class MakeAstromanDelete {
    public function make(FormBuilderInterface $form) {
        $form->add('id', HiddenType::class, ['label' => 'id']);        
        $form->add('sent', SubmitType::class, ['label' => 'Ano', 'attr' => ['data-button-side' => 'left']]);
        $form->add('cancel', ButtonType::class, ['label' => 'Ne', 'attr' => ['data-button-side' => 'right']]);
        return $form;
    }
}
