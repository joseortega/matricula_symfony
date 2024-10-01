<?php

namespace App\Entity;

use App\Repository\RequisitoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RequisitoRepository::class)]
class Requisito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'requisito', targetEntity: ExpedienteItem::class)]
    private Collection $expedienteItems;

    /**
     * @var Collection<int, GradoEscolarRequisito>
     */
    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'requisito', targetEntity: GradoEscolarRequisito::class)]
    private Collection $gradoEscolarRequisitos;

    public function __construct()
    {
        $this->expedienteItems = new ArrayCollection();
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

    /**
     * @return Collection<int, ExpedienteItem>
     */
    public function getExpedienteItems(): Collection
    {
        return $this->expedienteItems;
    }

    public function addExpedienteItem(ExpedienteItem $expedienteItem): static
    {
        if (!$this->expedienteItems->contains($expedienteItem)) {
            $this->expedienteItems->add($expedienteItem);
            $expedienteItem->setRequisito($this);
        }

        return $this;
    }

    public function removeExpedienteItem(ExpedienteItem $expedienteItem): static
    {
        if ($this->expedienteItems->removeElement($expedienteItem)) {
            // set the owning side to null (unless already changed)
            if ($expedienteItem->getRequisito() === $this) {
                $expedienteItem->setRequisito(null);
            }
        }

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
            $gradoEscolarRequisito->setRequisito($this);
        }

        return $this;
    }

    public function removeGradoEscolarRequisito(GradoEscolarRequisito $gradoEscolarRequisito): static
    {
        if ($this->gradoEscolarRequisitos->removeElement($gradoEscolarRequisito)) {
            // set the owning side to null (unless already changed)
            if ($gradoEscolarRequisito->getRequisito() === $this) {
                $gradoEscolarRequisito->setRequisito(null);
            }
        }

        return $this;
    }
}
