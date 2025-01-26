<?php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use \App\Events\AstroTabChanged;
use \App\Models\LogAstroTabChange;

class AstroTabChange implements EventSubscriberInterface
{
    public function __construct(
            protected LogAstroTabChange $logAstroTabChange
    )
    {
        
    }
    public static function getSubscribedEvents(): array
    {
        return [
            AstroTabChanged::ADDED => [
                ['added', 0],                
            ], 
            AstroTabChanged::DELETED => [
                ['deleted', 0],                
            ], 
            AstroTabChanged::UPDATED => [
                ['updated', 0],                
            ], 
        ];
    }
    
    public function added(AstroTabChanged $event)
    {
        $this->logAstroTabChange->logAction($event->getId(), $event->getDateTime(), 'added');
    }
    
    public function deleted(AstroTabChanged $event)
    {
        $this->logAstroTabChange->logAction($event->getId(), $event->getDateTime(), 'deleted');
    }
    
    public function updated(AstroTabChanged $event)
    {
        $this->logAstroTabChange->logAction($event->getId(), $event->getDateTime(), 'updated');
    }
    
}
