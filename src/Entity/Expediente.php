<?php

namespace App\Entity;

use App\Repository\ExpedienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    /**
     * @var Collection<int, Requisito>
     */
    #[ORM\ManyToMany(targetEntity: Requisito::class)]
    private Collection $requisitos;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $recibido_en = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $retirado_en = null;

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

    public function getRecibidoEn(): ?\DateTimeInterface
    {
        return $this->recibido_en;
    }

    public function setRecibidoEn(?\DateTimeInterface $recibido_en): static
    {
        $this->recibido_en = $recibido_en;

        return $this;
    }

    public function getRetiradoEn(): ?\DateTimeInterface
    {
        return $this->retirado_en;
    }

    public function setRetiradoEn(?\DateTimeInterface $retirado_en): static
    {
        $this->retirado_en = $retirado_en;

        return $this;
    }
}
