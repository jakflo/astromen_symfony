<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Models\Db_wrap;
use Symfony\Component\Form\Extension\Core\Type\FormType;

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

    public function addParam(string $name, $value) {
        $this->params[$name] = $value;
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
    
    protected function createNamedFormBuilder(string $name, $data = null, array $options = [])
    {
        return $this->container->get('form.factory')->createNamedBuilder($name, FormType::class, $data, $options);
    }
}
