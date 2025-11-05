<?php
namespace App\Forms\DataObjects;

class DataObjectsFactory
{
    public function __construct(
            protected \App\Forms\DataObjects\AstromanAdd $astromanAdd, 
            protected \App\Forms\DataObjects\AstromanDelete $astromanDelete, 
            protected \App\Forms\DataObjects\AstromanEdit $astromanEdit    
    )
    {
        
    }
    
    public function createAstromanAdd(): \App\Forms\DataObjects\AstromanAdd
    {
        return $this->astromanAdd;
    }
    
    public function createAstromanDelete(): \App\Forms\DataObjects\AstromanDelete
    {
        return $this->astromanDelete;
    }
    
    public function createAstromanEdit(): \App\Forms\DataObjects\AstromanEdit
    {
        return $this->astromanEdit;
    }
    
}
