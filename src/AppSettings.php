<?php

namespace App;

class AppSettings
{
    public function __construct(
        private readonly int $itemsPerPage,
    ) {}

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }
    
}
