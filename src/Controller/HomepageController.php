<?php

namespace App\Controller;
use App\Entity\Models\AstromenModel;

class HomepageController extends ExtendedController {
    public function displayPage() {
        $model = new AstromenModel($this->db);
        
        $astromen = $model->get_table();
        $this->addParam(array(
            'astromenData' => $astromen
        ));
        return $this->renderWithParams('homepage.html.twig');
    }
}
