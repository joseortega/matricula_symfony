<?php

namespace App\Entity;

use App\Repository\EstudianteRepresentanteRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use function Symfony\Component\Clock\now;

#[ORM\Entity(repositoryClass: EstudianteRepresentanteRepository::class)]
#[ORM\HasLifecycleCallbacks] // ¡Este atributo es crucial!
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
    private ?bool $principal = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $creadoEn = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $actualizadoEn = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parentesco $parentesco = null;

    #[ORM\PrePersist]
    public function setTimestampsOnCreate(): void
    {
        if ($this->creadoEn === null) {
            $this->creadoEn = new \DateTimeImmutable();
        }
        $this->actualizadoEn = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setTimestampsOnUpdate(): void
    {
        $this->actualizadoEn = new \DateTimeImmutable();
    }

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

    public function isPrincipal(): ?bool
    {
        return $this->principal;
    }

    public function setPrincipal(bool $principal): static
    {
        $this->principal = $principal;

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


    public function setCreadoEn(\DateTimeImmutable $creadoEn): static
    {
        $this->creadoEn = $creadoEn;

        return $this;
    }

    public function setActualizadoEn(\DateTimeImmutable $actualizadoEn): static
    {
        $this->actualizadoEn = $actualizadoEn;

        return $this;
    }

    public function getCreadoEn(): ?\DateTimeImmutable
    {
        return $this->creadoEn;
    }

    public function getActualizadoEn(): ?\DateTimeImmutable
    {
        return $this->actualizadoEn;
    }
}
