<?php
namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;

class AstroTabChanged extends Event
{
    const ADDED = 'astroTabChanged.added';
    const UPDATED = 'astroTabChanged.updated';
    const DELETED = 'astroTabChanged.deleted';
    
    protected \DateTime $dateTime;

    public function __construct(
            protected int $id
    )
    {
        $this->dateTime = new \DateTime();
    }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }
    
}
