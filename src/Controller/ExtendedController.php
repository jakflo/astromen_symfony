<?php
namespace App\Controller;

trait ExtendedController
{
    protected array $templateParameters;
    
    protected function addTemplateParameter(string $name, $value) {
        $this->templateParameters[$name] = $value;
    }
    
    protected function renderWithStoredParameters(string $twigPath) {
        return $this->render($twigPath, $this->templateParameters);
    }
}
