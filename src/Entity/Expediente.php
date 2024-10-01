<?php

namespace App\Entity;

use App\Repository\ExpedienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpedienteRepository::class)]
class Expediente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $observacion = null;

    #[ORM\OneToOne(inversedBy: 'expediente')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Estudiante $estudiante = null;

    #[ORM\OneToMany(mappedBy: 'expediente', targetEntity: ExpedienteItem::class)]
    private Collection $expedienteItems;

    public function __construct()
    {
        $this->expedienteItems = new ArrayCollection();
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

    public function getEstudiante(): ?Estudiante
    {
        return $this->estudiante;
    }

    public function setEstudiante(Estudiante $estudiante): static
    {
        $this->estudiante = $estudiante;

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
            $expedienteItem->setExpediente($this);
        }

        return $this;
    }

    public function removeExpedienteItem(ExpedienteItem $expedienteItem): static
    {
        if ($this->expedienteItems->removeElement($expedienteItem)) {
            // set the owning side to null (unless already changed)
            if ($expedienteItem->getExpediente() === $this) {
                $expedienteItem->setExpediente(null);
            }
        }

        return $this;
    }
}
