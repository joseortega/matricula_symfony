<?php

namespace App\Entity;

use App\Repository\MatriculaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Type;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MatriculaRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    fields: ['estudiante', 'periodoLectivo'],
    message: 'El estudiante ya ha sido matriculado en el periodo lectivo.',
    errorPath: 'PeriodoLectivo',
)]
class Matricula
{
    // Estados de la matrícula
    public const ESTADO_PREINSCRIPCION = 'PREINSCRIPCION'; // Intención de matricularse
    public const ESTADO_PENDIENTE      = 'PENDIENTE';      // Falta algún requisito
    public const ESTADO_ACTIVA         = 'ACTIVA';         // Matrícula vigente
    public const ESTADO_SUSPENDIDA     = 'SUSPENDIDA';     // Pausa temporal
    public const ESTADO_RETIRADA       = 'RETIRADA';       // Retiro voluntario
    public const ESTADO_ANULADA        = 'ANULADA';        // Anulada antes de iniciar
    public const ESTADO_FINALIZADA     = 'FINALIZADA';     // Finalizó el periodo
    public const ESTADO_TRASLADADA     = 'TRASLADADA';     // Traslado a otra sede/carrera

    public const ESTADOS = [
        self::ESTADO_PREINSCRIPCION,
        self::ESTADO_PENDIENTE,
        self::ESTADO_ACTIVA,
        self::ESTADO_SUSPENDIDA,
        self::ESTADO_RETIRADA,
        self::ESTADO_ANULADA,
        self::ESTADO_FINALIZADA,
        self::ESTADO_TRASLADADA,
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Type("DateTimeImmutable<'Y-m-d'>")]
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $fecha = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(inversedBy: 'matriculas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Estudiante $estudiante = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(inversedBy: 'matriculas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Jornada $jornada = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(inversedBy: 'matriculas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Modalidad $modalidad = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(inversedBy: 'matriculas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Paralelo $paralelo = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(inversedBy: 'matriculas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GradoEscolar $gradoEscolar = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(inversedBy: 'matriculas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PeriodoLectivo $periodoLectivo = null;

    #[Assert\NotBlank]
    #[Assert\Choice(self::ESTADOS)]
    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Type("DateTimeImmutable<'Y-m-d\TH:i:s.uP'>")]
    private ?\DateTimeImmutable $fechaCambioEstado = null;

    #[ORM\Column]
    private ?bool $inscritoEnSistemaPublico = true;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observacion = null;

    //Campo Temporal para detectar cambios
    private ?string $estadoAnterior = null;

    public function __construct()
    {
        $this->fechaCambioEstado = new \DateTimeImmutable();
        $this->estado = self::ESTADO_PREINSCRIPCION;
    }


    #[ORM\PostLoad]
    public function saveEstadoAnterior(): void
    {
        $this->estadoAnterior = $this->estado;
    }

    #[ORM\PreUpdate]
    public function updateFechaCambioEstado(): void
    {
        if($this->estado !== $this->estadoAnterior){
            $this->fechaCambioEstado = new \DateTimeImmutable();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeImmutable
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeImmutable $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getEstudiante(): ?Estudiante
    {
        return $this->estudiante;
    }

    public function setEstudiante(?Estudiante $estudiante): static
    {
        $this->estudiante = $estudiante;

        return $this;
    }

    public function getJornada(): ?Jornada
    {
        return $this->jornada;
    }

    public function setJornada(?Jornada $jornada): static
    {
        $this->jornada = $jornada;

        return $this;
    }

    public function getModalidad(): ?Modalidad
    {
        return $this->modalidad;
    }

    public function setModalidad(?Modalidad $modalidad): static
    {
        $this->modalidad = $modalidad;

        return $this;
    }

    public function getParalelo(): ?Paralelo
    {
        return $this->paralelo;
    }

    public function setParalelo(?Paralelo $paralelo): static
    {
        $this->paralelo = $paralelo;

        return $this;
    }

    public function getGradoEscolar(): ?GradoEscolar
    {
        return $this->gradoEscolar;
    }

    public function setGradoEscolar(?GradoEscolar $gradoEscolar): static
    {
        $this->gradoEscolar = $gradoEscolar;

        return $this;
    }

    public function getPeriodoLectivo(): ?PeriodoLectivo
    {
        return $this->periodoLectivo;
    }

    public function setPeriodoLectivo(?PeriodoLectivo $periodoLectivo): static
    {
        $this->periodoLectivo = $periodoLectivo;

        return $this;
    }

    public function isInscritoEnSistemaPublico(): ?bool
    {
        return $this->inscritoEnSistemaPublico;
    }

    public function setInscritoEnSistemaPublico(bool $inscritoEnSistemaPublico): static
    {
        $this->inscritoEnSistemaPublico = $inscritoEnSistemaPublico;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(?string $estado): static
    {
        if (!in_array($estado, self::ESTADOS, true)) {
            throw new \InvalidArgumentException("Estado de matrícula inválido: $estado");
        }
        $this->estado = $estado;
        return $this;
    }

    public function getFechaCambioEstado(): ?\DateTimeImmutable
    {
        return $this->fechaCambioEstado;
    }

    public function setFechaCambioEstado(?\DateTimeImmutable $fechaCambioEstado): static
    {
        $this->fechaCambioEstado = $fechaCambioEstado;

        return $this;
    }

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): static
    {
        $this->observacion = $observacion;

        return $this;
    }
}
