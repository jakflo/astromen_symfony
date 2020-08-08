<?php

namespace App\Forms\Makers;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class MakeAstromanEdit extends MakeAstromanAdd {
    public function make(FormBuilderInterface $form) {
        $form->add('id', TextType::class, ['label' => 'id']);
        $form = parent::make($form);
        $form->add('cancel', ButtonType::class, ['label' => 'Zrušit', 'attr' => ['data-button-side' => 'right']]);
        $form->add('sent', SubmitType::class, ['label' => 'Odeslat', 'attr' => ['data-button-side' => 'left']]);
        return $form;
    }
}
