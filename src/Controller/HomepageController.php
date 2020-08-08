<?php

namespace App\Controller;
use App\Entity\Models\AstromenModel;
use App\Forms\DataObjects\AstromanAdd;
use App\Forms\Makers\MakeAstromanAdd;
use App\Forms\DataObjects\AstromanEdit;
use App\Forms\Makers\MakeAstromanEdit;
use App\Forms\DataObjects\AstromanDelete;
use App\Forms\DataObjects\MakeAstromanDelete;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends ExtendedController {
    public function displayPage(Request $request) {
        $model = new AstromenModel($this->db);
        $astromanAdd = new AstromanAdd($this->db);
        $makeAstromanAdd = new MakeAstromanAdd;
        $astromanEdit = new AstromanEdit($this->db);
        $makeAstromanEdit = new MakeAstromanEdit;
        $astromanDelete = new AstromanDelete($this->db);
        $makeAstromanDelete = new MakeAstromanDelete;
        
        $astromamAddForm = $makeAstromanAdd->make($this->createNamedFormBuilder('add', $astromanAdd))->getForm();
        $astromamAddForm->handleRequest($request);
        $this->addParam('addForm', $astromamAddForm->createView());
        $this->addParam('add_form_validation_failed', false);
        
        $astromamEditForm = $makeAstromanEdit->make($this->createNamedFormBuilder('edit', $astromanEdit))->getForm();
        $astromamEditForm->handleRequest($request);
        $this->addParam('editForm', $astromamEditForm->createView());
        
        $astromamDeleteForm = $makeAstromanDelete->make($this->createNamedFormBuilder('delete', $astromanDelete))->getForm();
        $astromamDeleteForm->handleRequest($request);
        $this->addParam('deleteForm', $astromamDeleteForm->createView());
        
        if ($astromamAddForm->isSubmitted()) {
            if ($astromamAddForm->isValid()) {
                
            }
            else {
                $this->addParam('add_form_validation_failed', true);
            }
        }
        
        $astromen = $model->get_table();
        $this->addParam('astromenData', $astromen);
        return $this->renderWithParams('homepage.html.twig');
    }
}
