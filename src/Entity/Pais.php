<?php

namespace App\Entity;

use App\Repository\PaisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;

#[ORM\Entity(repositoryClass: PaisRepository::class)]
class Pais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $codigoNumerico = null;

    #[ORM\Column(length: 2)]
    private ?string $codigoAlpha2 = null;

    #[ORM\Column(length: 3)]
    private ?string $codigoAlpha3 = null;

    #[ORM\Column(length: 100)]
    private ?string $nombreComun = null;

    #[ORM\Column(length: 100)]
    private ?string $nacionalidad = null;

    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'paisNacionalidad', targetEntity: Estudiante::class, orphanRemoval: true)]
    private Collection $estudiantes;

    public function __construct()
    {
        $this->estudiantes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoNumerico(): ?int
    {
        return $this->codigoNumerico;
    }

    public function setCodigoNumerico(int $codigoNumerico): static
    {
        $this->codigoNumerico = $codigoNumerico;

        return $this;
    }

    public function getCodigoAlpha2(): ?string
    {
        return $this->codigoAlpha2;
    }

    public function setCodigoAlpha2(string $codigoAlpha2): static
    {
        $this->codigoAlpha2 = $codigoAlpha2;

        return $this;
    }

    public function getCodigoAlpha3(): ?string
    {
        return $this->codigoAlpha3;
    }

    public function setCodigoAlpha3(string $codigoAlpha3): static
    {
        $this->codigoAlpha3 = $codigoAlpha3;

        return $this;
    }

    public function getNombreComun(): ?string
    {
        return $this->nombreComun;
    }

    public function setNombreComun(string $nombreComun): static
    {
        $this->nombreComun = $nombreComun;

        return $this;
    }

    public function getNacionalidad(): ?string
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad(string $nacionalidad): static
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    public function getEstudiantes(): Collection
    {
        return $this->estudiantes;
    }

    public function addEstudiante(Estudiante $estudiante): static
    {
        if (!$this->estudiantes->contains($estudiante)) {
            $this->estudiantes->add($estudiante);
            $estudiante->setPaisNacionalidad($this);
        }

        return $this;
    }

    public function removeEstudiante(Estudiante $estudiante): static
    {
        if ($this->estudiantes->removeElement($estudiante)) {
            // set the owning side to null (unless already changed)
            if ($estudiante->getPaisNacionalidad() === $this) {
                $estudiante->setPaisNacionalidad(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nombreComun . ' - ' . $this->nacionalidad;
    }
}
