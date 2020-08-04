<?php

namespace App\Forms\Makers;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MakeAstromanAdd extends MakeAstromanCommon {
    public function make(FormBuilderInterface $form) {
         $form = parent::make($form);
         $form->add('sent', SubmitType::class, ['label' => 'Přidat']);
         return $form;
    }
}
