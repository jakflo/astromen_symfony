<?php
namespace App\Models;

use App\Utils\DateTools;
use Doctrine\ORM\EntityManagerInterface;
use \App\Entity\AstroTab;

class AstromenModel
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {
        
    }
    
    public function getTable(): array
    {
        return $this->entityManager->getRepository(AstroTab::class)->findAll();
    }
    
    public function getFullName(int $id) 
    {
        $row = $this->entityManager->getRepository(AstroTab::class)->findOneById($id);
        return trim("{$row->getFName()} {$row->getLName()}");
    }
    
    public function idExists(int $id) 
    {
        $row = $this->entityManager->getRepository(AstroTab::class)->findById($id);
        return count($row) > 0;
    }
    
    public function isNameExists(string $fName, string $lName, \DateTime $dob, int $id = 0) 
    {
        $row_query = $this->entityManager->createQueryBuilder()
                ->addSelect('a')
                ->from(AstroTab::class, 'a')
                ->andWhere('a.f_name = :fName')
                ->andWhere('a.l_name = :lName')
                ->andWhere('a.DOB = :dob')
                ->setParameters([
                    'fName' => trim($fName), 
                    'lName' => trim($lName), 
                    'dob' => $dob
                ])
                ;
        
        if ($id != 0 ) {
            $row_query->andWhere('a.id != :id')->setParameter('id', $id);
        }
        
        $row = $row_query->getQuery()->getResult();
        return count($row) > 0;
    }
    
    public function add(string $fName, string $lName, \DateTime $dob, string $skill) 
    {
        $new_row = new AstroTab();
        $new_row
                ->setFName(trim($fName))
                ->setLName(trim($lName))
                ->setDOB($dob)
                ->setSkill($skill)
                ;
        $this->entityManager->persist($new_row);
        $this->entityManager->flush();
    }
    
    public function delete(int $id) 
    {
        $row = $this->entityManager->getRepository(AstroTab::class)->findOneById($id);
        $this->entityManager->remove($row);
        $this->entityManager->flush();
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
    }
}
