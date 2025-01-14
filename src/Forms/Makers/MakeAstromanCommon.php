<?php

namespace App\Forms\Makers;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class MakeAstromanCommon {
    public function make(FormBuilderInterface $form) 
    {
        return $form
                ->add('fName', TextType::class, ['label' => 'Jméno'])
                ->add('lName', TextType::class, ['label' => 'Příjmení'])
                ->add('dob', DateType::class, [
                    'label' => 'Datum narození', 
                    'html5' => true, 
                    'widget' => 'single_text', 
                    'format' => DateType::HTML5_FORMAT
                ])
                ->add('skill', TextType::class, ['label' => 'Dovednost'])                
                ;
    }
}
