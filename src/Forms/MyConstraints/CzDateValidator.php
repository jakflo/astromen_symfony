<?php

namespace App\Forms\MyConstraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Utils\DateTools;

class CzDateValidator extends ConstraintValidator
{    
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }
        $dateTools = new DateTools;
        if (!$dateTools->checkCzDate($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }        
    }
}
