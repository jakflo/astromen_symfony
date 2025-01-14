<?php
namespace App\Forms\DataObjects;

class DataObjectsFactory
{
    public function __construct(
//            protected \App\Models\AstromenModel $astromen_model, 
            protected \App\Forms\DataObjects\AstromanAdd $astroman_add, 
            protected \App\Forms\DataObjects\AstromanDelete $astroman_delete, 
            protected \App\Forms\DataObjects\AstromanEdit $astroman_edit    
    )
    {
        
    }
    
    public function createAstromanAdd(): \App\Forms\DataObjects\AstromanAdd
    {
        return $this->astroman_add;
    }
    
    public function createAstromanDelete(): \App\Forms\DataObjects\AstromanDelete
    {
        return $this->astroman_delete;
    }
    
    public function createAstromanEdit(): \App\Forms\DataObjects\AstromanEdit
    {
        return $this->astroman_edit;
    }
    
}
