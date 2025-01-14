<?php
namespace App\Controller;

use App\Forms\Makers\MakeAstromanAdd;
use App\Forms\Makers\MakeAstromanEdit;
use App\Forms\DataObjects\MakeAstromanDelete;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController 
{
    use ExtendedController;
    
    public function __construct(
            protected \App\Models\AstromenModel $model, 
            protected \App\Forms\DataObjects\DataObjectsFactory $data_objects_factory
    )
    {
        
    }
    
    public function displayPage(Request $request) 
    {
        $this->addParam('title', 'Astronuts');
                
        $astromanAdd = $this->data_objects_factory->createAstromanAdd();
        $makeAstromanAdd = new MakeAstromanAdd;
        $astromanEdit = $this->data_objects_factory->createAstromanEdit();
        $makeAstromanEdit = new MakeAstromanEdit;
        $astromanDelete = $this->data_objects_factory->createAstromanDelete();
        $makeAstromanDelete = new MakeAstromanDelete;
        
        $astromamAddForm = $this->addForm($makeAstromanAdd, 'add', $astromanAdd, $request);
        $astromamEditForm = $this->addForm($makeAstromanEdit, 'edit', $astromanEdit, $request);
        $astromamDeleteForm = $this->addForm($makeAstromanDelete, 'delete', $astromanDelete, $request);        

        $this->addParam('add_form_validation_failed', false);        
        $this->addParam('edit_form_validation_failed_id', 0);
        
        if ($astromamAddForm->isSubmitted()) {
            if ($astromamAddForm->isValid()) {
                $this->model->add(
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
                $this->model->edit(
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
        if ($astromamDeleteForm->isSubmitted() && $astromamDeleteForm->isValid()) {
            $fullName = $this->model->getFullName($astromanDelete->getId());
            $this->model->delete($astromanDelete->getId());
            return $this->reloadWithFlash("Astronaut {$fullName} úspěšně smazán");
        }
        
        $this->addParam('astromenData', $this->model->getTable());
        return $this->renderWithParams('homepage.html.twig');
    }
    
    protected function reloadWithFlash(string $message) {
        $this->addFlash('notice', $message);
        return $this->redirectToRoute('homepage');        
    }
}
