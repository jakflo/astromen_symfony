<?php
namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

trait ExtendedController
{
    protected array $params;
    
    protected function addParam(string $name, $value) {
        $this->params[$name] = $value;
    }
    
    protected function renderWithParams(string $twigPath) {
        return $this->render($twigPath, $this->params);
    }
    
    protected function addForm($formMaker, string $formName, $formDataObject, Request $request) {
        $form = $formMaker->make($this->createNamedFormBuilder($formName, $formDataObject))->getForm();
        $form->handleRequest($request);
        $formName .= 'Form';
        $this->addParam($formName, $form->createView());
        return $form;        
    }
    
    protected function createNamedFormBuilder(string $name, $data = null, array $options = [])
    {
        return $this->container->get('form.factory')->createNamedBuilder($name, FormType::class, $data, $options);
    }
    
}
