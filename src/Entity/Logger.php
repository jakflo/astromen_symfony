<?php

namespace App\Entity;

use App\Repository\LoggerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoggerRepository::class)
 * @ORM\Table("logger")
 */
class Logger
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $astro_tab_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $action_id;

    /**
     * @ORM\ManyToOne(targetEntity=LoggerAction::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAstroTabId(): ?int
    {
        return $this->astro_tab_id;
    }

    public function setAstroTabId(int $astro_tab_id): self
    {
        $this->astro_tab_id = $astro_tab_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getActionId(): ?int
    {
        return $this->action_id;
    }

    public function setActionId(int $action_id): self
    {
        $this->action_id = $action_id;

        return $this;
    }

    public function getAction(): ?LoggerAction
    {
        return $this->action;
    }

    public function setAction(?LoggerAction $action): self
    {
        $this->action = $action;

        return $this;
    }
}
