<?php

namespace App\Entity;

use App\Repository\EstadoMatriculaRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EstadoMatriculaRepository::class)]
class EstadoMatricula
{
    // Estados de la matrícula
    public const PREINSCRIPCION = 'PREINSCRIPCION'; // Intención de matricularse
    public const PENDIENTE      = 'PENDIENTE';      // Falta algún requisito
    public const ACTIVA         = 'ACTIVA';         // Matrícula vigente
    public const SUSPENDIDA     = 'SUSPENDIDA';     // Pausa temporal
    public const ANULADA        = 'ANULADA';        // Anulada antes de iniciar
    public const RETIRADA      = 'RETIRADA';        // Se retira por algun motivo, no termina los estudios
    public const TRASLADADA     = 'TRASLADADA';     // Se traslada a otra institución

    public const ESTADOS = [
        self::PREINSCRIPCION,
        self::PENDIENTE,
        self::ACTIVA,
        self::SUSPENDIDA,
        self::ANULADA,
        self::RETIRADA,
        self::TRASLADADA,
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $detalle = null;

    #[Assert\Choice(self::ESTADOS)]
    #[ORM\Column(length: 30, unique: true)]
    private ?string $codigoSistema = null;

    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'estadoMatricula', targetEntity: Matricula::class)]
    private Collection $matriculas;

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

    public function getDetalle(): ?string
    {
        return $this->detalle;
    }

    public function setDetalle(string $detalle): static
    {
        $this->detalle = $detalle;

        return $this;
    }

    public function getCodigoSistema(): ?string
    {
        return $this->codigoSistema;
    }

    public function setCodigoSistema(string $codigoSistema): static
    {
        $this->codigoSistema = $codigoSistema;

        return $this;
    }

    public function getMatriculas(): Collection
    {
        return $this->matriculas;
    }
    public function addMatricula(Matricula $matricula): static
    {
        if (!$this->matriculas->contains($matricula)) {
            $this->matriculas->add($matricula);
            $matricula->setEstadoMatricula($this);
        }
        return $this;
    }

    public function removeMatricula(Matricula $matricula): static
    {
        if ($this->matriculas->removeElement($matricula)) {
            if ($matricula->getEstadoMatricula() === $this) {
                $matricula->setEstadoMatricula(null);
            }
        }
        return $this;
    }
}
