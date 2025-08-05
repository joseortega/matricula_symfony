<?php

namespace App\Entity;

use App\Repository\UniformeTallaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation\Exclude;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UniformeTallaRepository::class)]
class UniformeTalla
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, Estudiante>
     */
    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'uniformeTalla', targetEntity: Estudiante::class)]
    private Collection $estudiantes;

    public function __construct()
    {
        $this->estudiantes = new ArrayCollection();
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

    /**
     * @return Collection<int, Estudiante>
     */
    public function getEstudiantes(): Collection
    {
        return $this->estudiantes;
    }

    public function addEstudiante(Estudiante $estudiante): static
    {
        if (!$this->estudiantes->contains($estudiante)) {
            $this->estudiantes->add($estudiante);
            $estudiante->setUniformeTalla($this);
        }

        return $this;
    }

    public function removeEstudiante(Estudiante $estudiante): static
    {
        if ($this->estudiantes->removeElement($estudiante)) {
            // set the owning side to null (unless already changed)
            if ($estudiante->getUniformeTalla() === $this) {
                $estudiante->setUniformeTalla(null);
            }
        }

        return $this;
    }
}
