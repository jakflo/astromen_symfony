<?php

namespace App\Forms\MyConstraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 */
class CzDate extends Constraint
{
    public $message = 'Neplatné datum.';
}
