<?php

namespace App\Entity;

use App\Repository\CircuitoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CircuitoRepository::class)]
class Circuito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $codigo = null;

    #[ORM\Column(length: 255)]
    private ?string $denominacion = null;

    #[ORM\ManyToOne(inversedBy: 'circuitos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Distrito $distrito = null;

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

    public function getDistrito(): ?Distrito
    {
        return $this->distrito;
    }

    public function setDistrito(?Distrito $distrito): static
    {
        $this->distrito = $distrito;

        return $this;
    }
}
