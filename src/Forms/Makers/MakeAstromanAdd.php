<?php

namespace App\Forms\Makers;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class MakeAstromanAdd extends MakeAstromanCommon 
{
    public function make(FormBuilderInterface $form) {
         $form = parent::make($form);
         $form->add('sent', SubmitType::class, ['label' => 'Přidat', 'attr' => ['data-button-side' => 'left']]);
         $form->add('cancel', ButtonType::class, ['label' => 'Zrušit', 'attr' => ['data-button-side' => 'right']]);
         return $form;
    }
}
