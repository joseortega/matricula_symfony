<?php

namespace App\Entity;

use App\Repository\DistritoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DistritoRepository::class)]
class Distrito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $codigo = null;

    #[ORM\Column(length: 255)]
    private ?string $denominacion = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Zona $zona = null;

    /**
     * @var Collection<int, Circuito>
     */
    #[ORM\OneToMany(mappedBy: 'distrito', targetEntity: Circuito::class)]
    private Collection $circuitos;

    public function __construct()
    {
        $this->circuitos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): static
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getDenominacion(): ?string
    {
        return $this->denominacion;
    }

    public function setDenominacion(string $denominacion): static
    {
        $this->denominacion = $denominacion;

        return $this;
    }

    public function getZona(): ?Zona
    {
        return $this->zona;
    }

    public function setZona(?Zona $zona): static
    {
        $this->zona = $zona;

        return $this;
    }

    /**
     * @return Collection<int, Circuito>
     */
    public function getCircuitos(): Collection
    {
        return $this->circuitos;
    }

    public function addCircuito(Circuito $circuito): static
    {
        if (!$this->circuitos->contains($circuito)) {
            $this->circuitos->add($circuito);
            $circuito->setDistrito($this);
        }

        return $this;
    }

    public function removeCircuito(Circuito $circuito): static
    {
        if ($this->circuitos->removeElement($circuito)) {
            // set the owning side to null (unless already changed)
            if ($circuito->getDistrito() === $this) {
                $circuito->setDistrito(null);
            }
        }

        return $this;
    }
}
