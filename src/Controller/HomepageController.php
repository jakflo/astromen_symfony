<?php
namespace App\Controller;

use App\Forms\Makers\AstromanAddForm;
use App\Forms\Makers\AstromanEditForm;
use App\Forms\Makers\AstromanDeleteForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController 
{
    use ExtendedController;
    
    public function __construct(
            protected \App\Models\AstromenModel $model, 
            protected \App\Forms\DataObjects\DataObjectsFactory $dataObjectsFactory
    )
    {
        
    }
    
    public function displayPage(Request $request) 
    {
        $this->addTemplateParameter('title', 'Astronuts');
                
        $astromanAdd = $this->dataObjectsFactory->createAstromanAdd();
        $astromamAddForm = $this->createForm(AstromanAddForm::class, $astromanAdd);
        $astromamAddForm->handleRequest($request);
        
        $astromanEdit = $this->dataObjectsFactory->createAstromanEdit();
        $astromamEditForm = $this->createForm(AstromanEditForm::class, $astromanEdit);
        $astromamEditForm->handleRequest($request);
        
        $astromanDelete = $this->dataObjectsFactory->createAstromanDelete();
        $astromamDeleteForm = $this->createForm(AstromanDeleteForm::class, $astromanDelete);
        $astromamDeleteForm->handleRequest($request);
        
        $this->addTemplateParameter('addForm', $astromamAddForm->createView());
        $this->addTemplateParameter('editForm', $astromamEditForm->createView());
        $this->addTemplateParameter('deleteForm', $astromamDeleteForm->createView());

        $this->addTemplateParameter('add_form_validation_failed', false);        
        $this->addTemplateParameter('edit_form_validation_failed_id', 0);
        
        if ($astromamAddForm->isSubmitted()) {
            if ($astromamAddForm->isValid()) {
                $this->model->add(
                        $astromanAdd->getFName(), $astromanAdd->getLName(), 
                        $astromanAdd->getDob(), $astromanAdd->getSkill()
                        );
                return $this->reloadWithFlash("Astronaut {$astromanAdd->getFullName()} úspěšně přidán");
            }
            else {
                $this->addTemplateParameter('add_form_validation_failed', true);
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
                $this->addTemplateParameter('edit_form_validation_failed_id', $astromanEdit->getId());
            }
        }
        if ($astromamDeleteForm->isSubmitted() && $astromamDeleteForm->isValid()) {
            $fullName = $this->model->getFullName($astromanDelete->getId());
            $this->model->delete($astromanDelete->getId());
            return $this->reloadWithFlash("Astronaut {$fullName} úspěšně smazán");
        }
        
        $this->addTemplateParameter('astromenData', $this->model->getTable());
        return $this->renderWithStoredParameters('homepage.html.twig');
    }
    
    protected function reloadWithFlash(string $message) {
        $this->addFlash('notice', $message);
        return $this->redirectToRoute('homepage');        
    }
}
