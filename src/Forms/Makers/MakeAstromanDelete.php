<?php

namespace App\Forms\DataObjects;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MakeAstromanDelete {
    public function make(FormBuilderInterface $form) {
        $form->add('id', TextType::class, ['label' => 'id']);        
        $form->add('sent', SubmitType::class, ['label' => 'Smazat']);
        return $form;
    }
}
