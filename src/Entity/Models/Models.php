<?php

namespace App\Entity\Models;

class Models {
    protected $db;
    
    public function __construct(Db_wrap $db) {
        $this->db = $db;
    }
}
