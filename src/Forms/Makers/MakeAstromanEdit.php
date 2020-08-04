<?php

namespace App\Forms\Makers;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MakeAstromanEdit extends MakeAstromanAdd {
    public function make(FormBuilderInterface $form) {
        $form->add('id', TextType::class, ['label' => 'id']);
        $form = parent::make($form);
        $form->add('sent', SubmitType::class, ['label' => 'Odeslat']);
        return $form;
    }
}
