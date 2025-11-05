<?php
namespace App\Forms\Makers;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

trait TAddButtons
{
    protected function addButtons(FormBuilderInterface $builder, string $actionButtonLabel, string $cancelButtonLabel = 'Zrušit')
    {
        $builder
            ->add('sent', SubmitType::class, ['label' => $actionButtonLabel, 'attr' => ['data-button-side' => 'left']])
            ->add('cancel', ButtonType::class, ['label' => $cancelButtonLabel, 'attr' => ['data-button-side' => 'right']])
        ;
    }
}
