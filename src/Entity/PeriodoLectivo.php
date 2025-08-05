<?php

namespace App\Entity;

use App\Repository\PeriodoLectivoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PeriodoLectivoRepository::class)]
class PeriodoLectivo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $descripcion = null;
    
    #[Assert\NotBlank]
    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $fechaInicio = null;
    
    #[Assert\NotBlank]
    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable$fechaFin = null;

    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'periodoLectivo', targetEntity: Matricula::class)]
    private Collection $matriculas;

    #[ORM\Column]
    private ?bool $habilitadoParaMatricula = false;

    public function __construct()
    {
        $this->matriculas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }
    
    public function getFechaInicio(): ?\DateTimeImmutable
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeImmutable $fechaInicio): void
    {
        $this->fechaInicio = $fechaInicio;
    }
    
    public function getFechaFin(): ?\DateTimeImmutable
    {
        return $this->fechaFin;
    }

    public function setFechaFin(\DateTimeImmutable $fechaFin): void
    {
        $this->fechaFin = $fechaFin;
    }

    /**
     * @return Collection<int, Matricula>
     */
    public function getMatriculas(): Collection
    {
        return $this->matriculas;
    }

    public function addMatricula(Matricula $matricula): static
    {
        if (!$this->matriculas->contains($matricula)) {
            $this->matriculas->add($matricula);
            $matricula->setPeriodoLectivo($this);
        }

        return $this;
    }

    public function removeMatricula(Matricula $matricula): static
    {
        if ($this->matriculas->removeElement($matricula)) {
            // set the owning side to null (unless already changed)
            if ($matricula->getPeriodoLectivo() === $this) {
                $matricula->setPeriodoLectivo(null);
            }
        }

        return $this;
    }

    public function isHabilitadoParaMatricula(): ?bool
    {
        return $this->habilitadoParaMatricula;
    }

    public function setHabilitadoParaMatricula(bool $habilitadoParaMatricula): static
    {
        $this->habilitadoParaMatricula = $habilitadoParaMatricula;

        return $this;
    }

    public function __toString() {
        return $this->getDescripcion();
    }
}
