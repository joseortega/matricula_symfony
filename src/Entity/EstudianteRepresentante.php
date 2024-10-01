<?php

namespace App\Entity;

use App\Repository\EstudianteRepresentanteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EstudianteRepresentanteRepository::class)]

#[UniqueEntity(
    fields: ['estudiante', 'representante'],
    message: 'El estudiante ya tiene ese representate.',
    errorPath: 'Representante',
)]
class EstudianteRepresentante
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'estudianteRepresentantes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Estudiante $estudiante = null;

    #[ORM\ManyToOne(inversedBy: 'estudianteRepresentantes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Representante $representante = null;

    #[ORM\Column]
    private ?bool $esPrincipal = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parentesco $parentesco = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstudiante(): ?Estudiante
    {
        return $this->estudiante;
    }

    public function setEstudiante(?Estudiante $estudiante): static
    {
        $this->estudiante = $estudiante;

        return $this;
    }

    public function getRepresentante(): ?Representante
    {
        return $this->representante;
    }

    public function setRepresentante(?Representante $representante): static
    {
        $this->representante = $representante;

        return $this;
    }

    public function isEsPrincipal(): ?bool
    {
        return $this->esPrincipal;
    }

    public function setEsPrincipal(bool $esPrincipal): static
    {
        $this->esPrincipal = $esPrincipal;

        return $this;
    }

    public function getParentesco(): ?Parentesco
    {
        return $this->parentesco;
    }

    public function setParentesco(?Parentesco $parentesco): static
    {
        $this->parentesco = $parentesco;

        return $this;
    }
}
