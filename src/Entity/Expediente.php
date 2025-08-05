<?php

namespace App\Entity;

use App\Repository\ExpedienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpedienteRepository::class)]
#[ORM\HasLifecycleCallbacks] // ¡Este atributo es crucial!
class Expediente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $fechaIngreso = null;
    
    #[ORM\Column()]
    private ?bool $completo = false;

    #[ORM\Column]
    private ?bool $retirado = false;
    
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $fechaRetiro = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observacion = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $creadoEn = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $actualizadoEn = null;
    
    /**
     * @var Collection<int, Requisito>
     */
    #[ORM\ManyToMany(targetEntity: Requisito::class)]
    private Collection $requisitos;

    #[ORM\OneToOne(inversedBy: 'expediente', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Estudiante $estudiante = null;

    public function __construct()
    {
        $this->requisitos = new ArrayCollection();
    }

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

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(string $observacion): static
    {
        $this->observacion = $observacion;

        return $this;
    }
    
    /**
     * @return Collection<int, Requisito>
     */
    public function getRequisitos(): Collection
    {
        return $this->requisitos;
    }

    public function addRequisito(Requisito $requisito): static
    {
        if (!$this->requisitos->contains($requisito)) {
            $this->requisitos->add($requisito);
        }

        return $this;
    }

    public function removeRequisito(Requisito $requisito): static
    {
        $this->requisitos->removeElement($requisito);

        return $this;
    }

    public function getFechaIngreso(): ?\DateTimeImmutable
    {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso(?\DateTimeImmutable $fechaIngreso): static
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    public function getFechaRetiro(): ?\DateTimeImmutable
    {
        return $this->fechaRetiro;
    }

    public function setFechaRetiro(?\DateTimeImmutable $fechaRetiro): static
    {
        $this->fechaRetiro = $fechaRetiro;

        return $this;
    }

    public function isCompleto(): ?bool
    {
        return $this->completo;
    }

    public function setCompleto(?bool $completo): static
    {
        $this->completo = $completo;

        return $this;
    }

    public function isRetirado(): ?bool
    {
        return $this->retirado;
    }

    public function setRetirado(bool $esta_retirado): static
    {
        $this->retirado = $esta_retirado;

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

    public function getEstudiante(): ?Estudiante
    {
        return $this->estudiante;
    }

    public function setEstudiante(Estudiante $estudiante): static
    {
        $this->estudiante = $estudiante;

        return $this;
    }
}
