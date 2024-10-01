<?php

namespace App\Entity;

use App\Repository\GradoEscolarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GradoEscolarRepository::class)]
class GradoEscolar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;
    
    #[ORM\Column(nullable: true)]
    private ?int $secuencia = null;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(inversedBy: 'gradoEscolars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nivel $nivel = null;

    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'gradoEscolar', targetEntity: Matricula::class)]
    private Collection $matriculas;

    /**
     * @var Collection<int, GradoEscolarRequisito>
     */
    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'gradoEscolar', targetEntity: GradoEscolarRequisito::class)]
    private Collection $gradoEscolarRequisitos;

    public function __construct()
    {
        $this->matriculas = new ArrayCollection();
        $this->gradoEscolarRequisitos = new ArrayCollection();
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

    public function getNivel(): ?Nivel
    {
        return $this->nivel;
    }

    public function setNivel(?Nivel $nivel): static
    {
        $this->nivel = $nivel;

        return $this;
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
            $matricula->setGradoEscolar($this);
        }

        return $this;
    }

    public function removeMatricula(Matricula $matricula): static
    {
        if ($this->matriculas->removeElement($matricula)) {
            // set the owning side to null (unless already changed)
            if ($matricula->getGradoEscolar() === $this) {
                $matricula->setGradoEscolar(null);
            }
        }

        return $this;
    }

    public function getSecuencia(): ?int
    {
        return $this->secuencia;
    }

    public function setSecuencia(?int $secuencia): static
    {
        $this->secuencia = $secuencia;

        return $this;
    }

    /**
     * @return Collection<int, GradoEscolarRequisito>
     */
    public function getGradoEscolarRequisitos(): Collection
    {
        return $this->gradoEscolarRequisitos;
    }

    public function addGradoEscolarRequisito(GradoEscolarRequisito $gradoEscolarRequisito): static
    {
        if (!$this->gradoEscolarRequisitos->contains($gradoEscolarRequisito)) {
            $this->gradoEscolarRequisitos->add($gradoEscolarRequisito);
            $gradoEscolarRequisito->setGradoEscolar($this);
        }

        return $this;
    }

    public function removeGradoEscolarRequisito(GradoEscolarRequisito $gradoEscolarRequisito): static
    {
        if ($this->gradoEscolarRequisitos->removeElement($gradoEscolarRequisito)) {
            // set the owning side to null (unless already changed)
            if ($gradoEscolarRequisito->getGradoEscolar() === $this) {
                $gradoEscolarRequisito->setGradoEscolar(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->getDescripcion();
    }
}
