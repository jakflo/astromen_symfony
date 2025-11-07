<?php

namespace App\Factory;

use \App\Models\Paginator;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class PaginatorFactory
{
    public function __construct(
            protected \App\AppSettings $appSettings
    )
    {}
    
    public function create(
            Query|QueryBuilder $query, 
            int $curentPage, 
            bool $fetchJoinCollection = true
            ): Paginator
    {
        return new Paginator($query, $this->appSettings->getItemsPerPage(), $curentPage, $fetchJoinCollection);
    }
}
