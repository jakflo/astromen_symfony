<?php
namespace App\Models;

use Doctrine\ORM\EntityManagerInterface;
use \App\Entity\Logger;
use \App\Entity\LoggerAction;

class LogAstroTabChange
{
    public function __construct(
        protected EntityManagerInterface $entityManager
    )
    {
        
    }
    
    public function logAction(int $id, \DateTime $dateTime, string $actionShortName)
    {
        $action = $this->entityManager->getRepository(LoggerAction::class)->findOneBy(['short_name' => $actionShortName]);
        if (!$action) {
            throw new \Exception('Neplatna akce');
        }
        
        $log = new Logger();
        $log
                ->setAction($action)
                ->setAstroTabId($id)
                ->setDate($dateTime)
                ;
        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}
