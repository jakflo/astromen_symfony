<?php
namespace App\Controller;

use App\Forms\Makers\AstromanAddForm;
use App\Forms\Makers\AstromanEditForm;
use App\Forms\Makers\AstromanDeleteForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomepageController extends AbstractController 
{
    use ExtendedController;

    public function __construct(
            protected \App\Models\AstromenModel $model, 
            protected \App\Factory\DataObjectsFactory $dataObjectsFactory, 
            protected \App\Factory\PaginatorFactory $paginatorFactory, 
            protected \App\AppSettings $appSettings
    ){}
    
    public function displayPage(Request $request): Response
    {
        $this->addTemplateParameter('title', 'Astronuts');
        $this->addTemplateParameter('add_form_validation_failed', false);        
        $this->addTemplateParameter('edit_form_validation_failed_id', 0);
        
        // prida formular do sablony, zpracuje v pripade submit a bud vrati Redirect nebo null
        $astromanAddFormResponse = $this->addFormAstromanAdd($request);
        $astromanEditFormResponse = $this->addFormAstromanEdit($request);
        $astromanDeleteFormResponse = $this->addFormAstromanDelete($request);
        
        // bud nektery z formlaru vrati Redirect a ten pouziji, nebo vyrendruji tabulku s astronauty
        if ($astromanAddFormResponse !== null) {
            return $astromanAddFormResponse;
        } elseif ($astromanEditFormResponse !== null) {
            return $astromanEditFormResponse;
        } elseif ($astromanDeleteFormResponse !== null) {
            return $astromanDeleteFormResponse;        
        } else {
            $this->addTemplateParameter('astromenData', $this->model->getTable($this->getCurrentPage($request)));
            return $this->renderWithStoredParameters('homepage.html.twig');
        }
    }
    
    protected function addFormAstromanAdd(Request $request): RedirectResponse | null
    {
        $astromanAdd = $this->dataObjectsFactory->createAstromanAdd();
        $astromamAddForm = $this->createForm(AstromanAddForm::class, $astromanAdd);
        $astromamAddForm->handleRequest($request);
        $this->addTemplateParameter('addForm', $astromamAddForm->createView());
        
        if ($astromamAddForm->isSubmitted()) {
            if ($astromamAddForm->isValid()) {
                $this->model->add(
                        $astromanAdd->getFName(), $astromanAdd->getLName(), 
                        $astromanAdd->getDob(), $astromanAdd->getSkill()
                );
                
                return $this->reloadWithFlash("Astronaut {$astromanAdd->getFullName()} úspěšně přidán", ['page' => $this->getPagesCount()]);
            }
            else {
                $this->addTemplateParameter('add_form_validation_failed', true);
            }
        }
        
        return null;
    }
    
    protected function addFormAstromanEdit(Request $request): RedirectResponse | null
    {
        $astromanEdit = $this->dataObjectsFactory->createAstromanEdit();
        $astromamEditForm = $this->createForm(AstromanEditForm::class, $astromanEdit);
        $astromamEditForm->handleRequest($request);
        $this->addTemplateParameter('editForm', $astromamEditForm->createView());
        
        if ($astromamEditForm->isSubmitted()) {
            if ($astromamEditForm->isValid()) {
                $this->model->edit(
                        $astromanEdit->getId(), $astromanEdit->getFName(), 
                        $astromanEdit->getLName(), $astromanEdit->getDob(), 
                        $astromanEdit->getSkill()
                        );
                return $this->reloadWithFlash("Astronaut {$astromanEdit->getFullName()} úspěšně upraven", ['page' => $this->getCurrentPage($request)]);
            }
            else {
                $this->addTemplateParameter('edit_form_validation_failed_id', $astromanEdit->getId());
            }
        }
        
        return null;
    }
    
    protected function addFormAstromanDelete(Request $request): RedirectResponse | null
    {
        $astromanDelete = $this->dataObjectsFactory->createAstromanDelete();
        $astromamDeleteForm = $this->createForm(AstromanDeleteForm::class, $astromanDelete);
        $astromamDeleteForm->handleRequest($request);
        $this->addTemplateParameter('deleteForm', $astromamDeleteForm->createView());
        
        if ($astromamDeleteForm->isSubmitted() && $astromamDeleteForm->isValid()) {
            $fullName = $this->model->getFullName($astromanDelete->getId());
            $this->model->delete($astromanDelete->getId());
            $pagesCount = $this->getPagesCount();
            $page = $pagesCount < $this->getCurrentPage($request) ? $pagesCount : $this->getCurrentPage($request); //pokud smazu jedinou polozku na posledni strance, snizi se pocet stranek
            return $this->reloadWithFlash("Astronaut {$fullName} úspěšně smazán", ['page' => $page]);
        }
        
        return null;
    }
    
    protected function getPagesCount(): int
    {
        $itemsCount = $this->model->getItemsCount();
        return ceil($itemsCount / $this->appSettings->getItemsPerPage());
    }
    
    protected function getCurrentPage(Request $request): int
    {
        return $request->query->getInt('page', 1);
    }
    
}
