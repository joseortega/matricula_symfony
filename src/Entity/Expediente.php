<?php

namespace App\Entity;

use App\Repository\ExpedienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpedienteRepository::class)]
class Expediente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaIngreso = null;
    
    #[ORM\Column()]
    private ?bool $esta_completo = false;

    #[ORM\Column]
    private ?bool $esta_retirado = false;
    
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaRetiro = null;

    #[ORM\Column(length: 255)]
    private ?string $observacion = null;
    
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

    public function getFechaIngreso(): ?\DateTimeInterface
    {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso(?\DateTimeInterface $fechaIngreso): static
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    public function getFechaRetiro(): ?\DateTimeInterface
    {
        return $this->fechaRetiro;
    }

    public function setFechaRetiro(?\DateTimeInterface $fechaRetiro): static
    {
        $this->fechaRetiro = $fechaRetiro;

        return $this;
    }

    public function isEstaCompleto(): ?bool
    {
        return $this->esta_completo;
    }

    public function setEstaCompleto(?bool $esta_completo): static
    {
        $this->esta_completo = $esta_completo;

        return $this;
    }

    public function isEstaRetirado(): ?bool
    {
        return $this->esta_retirado;
    }

    public function setEstaRetirado(bool $esta_retirado): static
    {
        $this->esta_retirado = $esta_retirado;

        return $this;
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
