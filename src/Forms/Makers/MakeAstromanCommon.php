<?php

namespace App\Forms\Makers;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class MakeAstromanCommon {
    public function make(FormBuilderInterface $form) {
        return $form
                ->add('fName', TextType::class, ['label' => 'Jméno'])
                ->add('lName', TextType::class, ['label' => 'Příjmení'])
                ->add('dob', TextType::class, ['label' => 'Datum narození'])
                ->add('skill', TextType::class, ['label' => 'Dovednost'])                
                ;
    }
}
