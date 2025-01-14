<?php

namespace App\Forms\DataObjects;

class AstromanDelete {
    public function __construct(
            protected \App\Models\AstromenModel $astromen_model
    )
    {
        
    }
    
    use AstromanIdTrait;    
}
