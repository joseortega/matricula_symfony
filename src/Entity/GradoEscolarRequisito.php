<?php

namespace App\Entity;

use App\Repository\GradoEscolarRequisitoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradoEscolarRequisitoRepository::class)]
class GradoEscolarRequisito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'gradoEscolarRequisitos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GradoEscolar $gradoEscolar = null;

    #[ORM\ManyToOne(inversedBy: 'gradoEscolarRequisitos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Requisito $requisito = null;

    #[ORM\Column]
    private ?bool $es_obligatorio = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGradoEscolar(): ?GradoEscolar
    {
        return $this->gradoEscolar;
    }

    public function setGradoEscolar(?GradoEscolar $gradoEscolar): static
    {
        $this->gradoEscolar = $gradoEscolar;

        return $this;
    }

    public function getRequisito(): ?Requisito
    {
        return $this->requisito;
    }

    public function setRequisito(?Requisito $requisito): static
    {
        $this->requisito = $requisito;

        return $this;
    }

    public function isEsObligatorio(): ?bool
    {
        return $this->es_obligatorio;
    }

    public function setEsObligatorio(bool $es_obligatorio): static
    {
        $this->es_obligatorio = $es_obligatorio;

        return $this;
    }
}
