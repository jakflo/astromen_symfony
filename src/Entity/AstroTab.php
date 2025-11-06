<?php

namespace App\Entity;

use \Doctrine\ORM\Mapping as ORM;
use App\Repository\AstroTabRepository;

#[ORM\Entity(repositoryClass: AstroTabRepository::class)]
#[ORM\Table(name: 'astro_tab')]
class AstroTab
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $f_name = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $l_name = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTime $DOB = null;

    #[ORM\Column(type: 'string', length: 45)]
    private ?string $skill = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFName(): ?string
    {
        return $this->f_name;
    }

    public function setFName(string $f_name): self
    {
        $this->f_name = $f_name;

        return $this;
    }

    public function getLName(): ?string
    {
        return $this->l_name;
    }

    public function setLName(string $l_name): self
    {
        $this->l_name = $l_name;

        return $this;
    }

    public function getDOB(): ?\DateTimeInterface
    {
        return $this->DOB;
    }

    public function setDOB(\DateTimeInterface $DOB): self
    {
        $this->DOB = $DOB;

        return $this;
    }

    public function getSkill(): ?string
    {
        return $this->skill;
    }

    public function setSkill(string $skill): self
    {
        $this->skill = $skill;

        return $this;
    }
}
