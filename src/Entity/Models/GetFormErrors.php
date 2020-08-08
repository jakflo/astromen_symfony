<?php

namespace App\Entity\Models;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormErrorIterator;

class GetFormErrors {
    protected $errors = array();
    
    public function __construct(FormView $form) {
        if (isset($form->vars['errors'])) {
                $this->getErrorsFromFormErrorIterator($form->vars['errors']);
            }
        foreach ($form->children as $child) {
            $vars = $child->vars;
            if (isset($vars['errors'])) {
                $this->getErrorsFromFormErrorIterator($vars['errors']);
            }                        
        }
    }
    
    protected function getErrorsFromFormErrorIterator(FormErrorIterator $iter) {
        $current = $iter->current();
        if (!empty($current)) {
            $this->addError($current->getMessage());
        }
        while ($current = $iter->next()) {
            $this->addError($current->getMessage());
        }
    }
    
    protected function addError(string $error) {
        if (!in_array($error, $this->errors)) {
            $this->errors[] = $error;
        }
    }
    
    public function getErrors() {
        return $this->errors;
    }
}
