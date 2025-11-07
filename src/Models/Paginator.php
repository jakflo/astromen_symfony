<?php

namespace App\Models;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class Paginator extends \Doctrine\ORM\Tools\Pagination\Paginator
{
    private int $itemsTotalCount;
    
    public function __construct(
            Query|QueryBuilder $query, 
            private int $itemsPerPage, 
            private int $curentPage, 
            bool $fetchJoinCollection = true
    )
    {
        $query
                ->setFirstResult(($this->curentPage - 1) * $this->itemsPerPage)
                ->setMaxResults($this->itemsPerPage)
        ;
        
        parent::__construct($query, $fetchJoinCollection);
        $this->itemsTotalCount = $this->count();
    }
    
    public function getPagesCount(): int
    {
        return ceil($this->itemsTotalCount / $this->itemsPerPage);
    }
    
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }
    
    public function getItemsTotalCount(): int
    {
        return $this->itemsTotalCount;
    }
    
    public function getCurrentPage(): int
    {
        return $this->curentPage;
    }
    
}
