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
    
    // jediny prinos tehle factory je automaticke nacteni items_per_page ze services.yaml
    // potrebujes-li Paginator s jinym items_per_page, vytvor objekt Paginator bez factory
    public function create(
            Query|QueryBuilder $query, 
            int $curentPage, 
            bool $fetchJoinCollection = true
            ): Paginator
    {
        return new Paginator($query, $this->appSettings->getItemsPerPage(), $curentPage, $fetchJoinCollection);
    }
}
