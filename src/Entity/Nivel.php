<?php

namespace App\Entity;

use App\Repository\NivelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NivelRepository::class)]
class Nivel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $descripcion = null;

    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'nivel', targetEntity: GradoEscolar::class)]
    private Collection $gradoEscolars;

    public function __construct()
    {
        $this->gradoEscolars = new ArrayCollection();
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
     * @return Collection<int, GradoEscolar>
     */
    public function getGradoEscolars(): Collection
    {
        return $this->gradoEscolars;
    }

    public function addGradoEscolar(GradoEscolar $gradoEscolar): static
    {
        if (!$this->gradoEscolars->contains($gradoEscolar)) {
            $this->gradoEscolars->add($gradoEscolar);
            $gradoEscolar->setNivel($this);
        }

        return $this;
    }

    public function removeGradoEscolar(GradoEscolar $gradoEscolar): static
    {
        if ($this->gradoEscolars->removeElement($gradoEscolar)) {
            // set the owning side to null (unless already changed)
            if ($gradoEscolar->getNivel() === $this) {
                $gradoEscolar->setNivel(null);
            }
        }

        return $this;
    }
}
