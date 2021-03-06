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
        
        $astromamAddForm = $this->addForm($makeAstromanAdd, 'add', $astromanAdd, $request);
        $astromamEditForm = $this->addForm($makeAstromanEdit, 'edit', $astromanEdit, $request);
        $astromamDeleteForm = $this->addForm($makeAstromanDelete, 'delete', $astromanDelete, $request);        

        $this->addParam('add_form_validation_failed', false);        
        $this->addParam('edit_form_validation_failed_id', 0);
        
        if ($astromamAddForm->isSubmitted()) {
            if ($astromamAddForm->isValid()) {
                $model->add(
                        $astromanAdd->getFName(), $astromanAdd->getLName(), 
                        $astromanAdd->getDob(), $astromanAdd->getSkill()
                        );
                return $this->reloadWithFlash("Astronaut {$astromanAdd->getFullName()} úspěšně přidán");
            }
            else {
                $this->addParam('add_form_validation_failed', true);
            }
        }
        if ($astromamEditForm->isSubmitted()) {
            if ($astromamEditForm->isValid()) {
                $model->edit(
                        $astromanEdit->getId(), $astromanEdit->getFName(), 
                        $astromanEdit->getLName(), $astromanEdit->getDob(), 
                        $astromanEdit->getSkill()
                        );
                return $this->reloadWithFlash("Astronaut {$astromanEdit->getFullName()} úspěšně upraven");
            }
            else {
                $this->addParam('edit_form_validation_failed_id', $astromanEdit->getId());
            }
        }
        if ($astromamDeleteForm->isSubmitted() and $astromamDeleteForm->isValid()) {
            $fullName = $model->getFullName($astromanDelete->getId());
            $model->delete($astromanDelete->getId());
            return $this->reloadWithFlash("Astronaut {$fullName} úspěšně smazán");
        }
        
        $astromen = $model->get_table();
        $this->addParam('astromenData', $astromen);
        return $this->renderWithParams('homepage.html.twig');
    }
    
    protected function reloadWithFlash(string $message) {
        $this->addFlash('notice', $message);
        return $this->redirect($this->getWebroot());        
    }
}
