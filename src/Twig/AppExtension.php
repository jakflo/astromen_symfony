<?php

namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Models\GetFormErrors;

class AppExtension extends AbstractExtension {
    public function getFunctions()
    {
        return [
            new TwigFunction('getFormErrors', [$this, 'getFormErrors']),
        ];
    }

    public function getFormErrors($form)
    {
        $errors = new GetFormErrors($form);
        return $errors->getErrors();
    }
}
