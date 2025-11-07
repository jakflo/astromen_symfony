<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

trait ExtendedController
{
    protected array $templateParameters = [];
    
    protected function addTemplateParameter(string $name, $value): self {
        $this->templateParameters[$name] = $value;
        return $this;
    }
    
    protected function renderWithStoredParameters(string $twigPath): Response {
        return $this->render($twigPath, $this->templateParameters);
    }
    
    protected function reloadWithFlash(string $message, array $parameters = []): RedirectResponse {
        $this->addFlash('notice', $message);
        return $this->redirectToRoute('homepage', $parameters);        
    }
    
}
