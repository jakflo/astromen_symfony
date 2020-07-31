<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Models\Db_wrap;

class ExtendedController extends AbstractController {
    /**
     *
     * @var Db_wrap
     */
    protected $db;
    
    /**
     *
     * @var array
     */
    protected $params;
    protected $title = 'Astromen';
    
    public function __construct() {
        $this->params = array(
            'title' => $this->title, 
            'webroot' => $this->getWebroot()
                );
        $this->db = $this->getDb();
    }

    public function addParam(array $param) {
        $this->params = array_merge($this->params, $param);
    }
    
    public function renderWithParams(string $twigPath) {
        return $this->render($twigPath, $this->params);
    }
    
    public function getWebroot() {
        $http = isset($_SERVER['HTTPS'])? 'https://' : 'http://';
        return $http.$_SERVER['HTTP_HOST'];
    }
    
    protected function getDb() {
        $db = new Db_wrap(
                'localhost', 
                'root', 
                '12345', 
                'astro'
                );
        return $db;
    }
}
