<?php
namespace App\Models;

use Doctrine\ORM\EntityManagerInterface;
use \App\Entity\AstroTab;
use \App\Events\AstroTabChanged;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use \App\Models\Paginator;

class AstromenModel
{
    public function __construct(
        protected EntityManagerInterface $entityManager, 
        protected EventDispatcherInterface $dispatcher, 
        protected \App\Factory\PaginatorFactory $paginatorFactory
    )
    {}
    
    public function getTable(int $page): Paginator
    {
        $query = $this->entityManager->createQueryBuilder()
            ->select('a')
            ->from(AstroTab::class, 'a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ;
        
        return $this->paginatorFactory->create($query, $page);
    }
    
    public function getItemsCount(): int
    {
        return (int)$this->entityManager->getConnection()->fetchOne(
                "SELECT COUNT(*) FROM astro_tab"
        );
    }
    
    public function getFullName(int $id): string
    {
        $row = $this->entityManager->getRepository(AstroTab::class)->findOneById($id);
        return trim("{$row->getFName()} {$row->getLName()}");
    }
    
    public function idExists(int $id): bool
    {
        $row = $this->entityManager->getRepository(AstroTab::class)->findById($id);
        return count($row) > 0;
    }
    
    public function isNameExists(string $fName, string $lName, \DateTime $dob, int $id = 0): bool 
    {
        $rowQuery = $this->entityManager->createQueryBuilder()
                ->addSelect('a')
                ->from(AstroTab::class, 'a')
                ->andWhere('a.f_name = :fName')
                ->andWhere('a.l_name = :lName')
                ->andWhere('a.DOB = :dob')
                ->setParameters(
                    new ArrayCollection([
                        new Parameter('fName', trim($fName)), 
                        new Parameter('lName', trim($lName)), 
                        new Parameter('dob', $dob)
                    ])
                )
                ;
        
        if ($id != 0 ) {
            $rowQuery->andWhere('a.id != :id')->setParameter('id', $id);
        }
        
        $row = $rowQuery->getQuery()->getResult();
        return count($row) > 0;
    }
    
    public function add(string $fName, string $lName, \DateTime $dob, string $skill) 
    {
        $newRow = new AstroTab();
        $newRow
                ->setFName(trim($fName))
                ->setLName(trim($lName))
                ->setDOB($dob)
                ->setSkill($skill)
                ;
        $this->entityManager->persist($newRow);
        $this->entityManager->flush();
        $this->logChange($newRow->getId(), AstroTabChanged::ADDED);
    }
    
    public function delete(int $id) 
    {
        $row = $this->entityManager->getRepository(AstroTab::class)->findOneById($id);
        $this->entityManager->remove($row);
        $this->entityManager->flush();
        $this->logChange($id, AstroTabChanged::DELETED);
    }
    
    public function edit(int $id, string $fName, string $lName, \DateTime $dob, string $skill) 
    {
        $row = $this->entityManager->getRepository(AstroTab::class)->findOneById($id);
        $row
                ->setFName(trim($fName))
                ->setLName(trim($lName))
                ->setDOB($dob)
                ->setSkill($skill)
                ;
        $this->entityManager->flush();
        $this->logChange($id, AstroTabChanged::UPDATED);
    }
    
    protected function logChange(int $id, string $eventName)
    {
        $event = new AstroTabChanged($id);
        $this->dispatcher->dispatch($event, $eventName);
    }
}
