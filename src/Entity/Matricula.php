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
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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

    #[ORM\Column]
    private ?bool $inscripcionAutomatica = false;

    #[Assert\NotBlank]
    #[Type("DateTimeImmutable<'Y-m-d'>")]
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $fechaInscripcion = null;

    #[ORM\Column]
    private ?bool $inscritoSistemaPublico = true;

    #[ORM\Column]
    private ?bool $legalizada = false;

    #[Type("DateTimeImmutable<'Y-m-d'>")]
    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $fechaLegalizacion = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(inversedBy: 'matriculas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EstadoMatricula $estadoMatricula = null;

    //Campo Temporal para detectar cambios
    private ?EstadoMatricula $estadoAnterior = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Type("DateTimeImmutable<'Y-m-d\TH:i:s.uP'>")]
    private ?\DateTimeImmutable $fechaCambioEstado = null;

    #[ORM\Column]
    private ?bool $promovida = false;
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observacion = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $creadoEn = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $actualizadoEn = null;

    public function __construct()
    {
        $this->fechaCambioEstado = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\PostLoad]
    public function saveEstadoAnterior(): void
    {
        $this->estadoAnterior = $this->estadoMatricula;
    }

    #[ORM\PreUpdate]
    public function updateFechaCambioEstado(): void
    {
        if($this->estadoMatricula->getId() !== $this->estadoAnterior->getId()){
            $this->fechaCambioEstado = new \DateTimeImmutable();
        }
    }

    #[ORM\PrePersist]
    public function setTimestampsOnCreate(): void
    {
        if ($this->creadoEn === null) {
            $this->creadoEn = new \DateTimeImmutable();
        }

        $this->actualizadoEn = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setTimestampsOnUpdate(): void
    {
        $this->actualizadoEn = new \DateTimeImmutable();
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

    public function isInscritoSistemaPublico(): ?bool
    {
        return $this->inscritoSistemaPublico;
    }

    public function setInscritoSistemaPublico(bool $inscritoSistemaPublico): static
    {
        $this->inscritoSistemaPublico = $inscritoSistemaPublico;

        return $this;
    }

    public function isPromovida(): ?bool
    {
        return $this->promovida;
    }

    public function setPromovida(bool $promovida): static
    {
        $this->promovida = $promovida;

        return $this;
    }

    public function getEstadoMatricula(): ?EstadoMatricula
    {
        return $this->estadoMatricula;
    }

    public function setEstadoMatricula(?EstadoMatricula $estadoMatricula): static
    {
        $this->estadoMatricula = $estadoMatricula;
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


    public function isLegalizada(): ?bool
    {
        return $this->legalizada;
    }

    public function setLegalizada(bool $legalizada): static
    {
        $this->legalizada = $legalizada;
        
        return $this;
    }

    public function getFechaInscripcion(): ?\DateTimeImmutable
    {
        return $this->fechaInscripcion;
    }

    public function setFechaInscripcion(?\DateTimeImmutable $fechaInscripcion): static
    {
        $this->fechaInscripcion = $fechaInscripcion;

        return $this;
    }

    public function getFechaLegalizacion(): ?\DateTimeImmutable
    {
        return $this->fechaLegalizacion;
    }

    public function setFechaLegalizacion(?\DateTimeImmutable $fechaLegalizacion): static
    {
        $this->fechaLegalizacion = $fechaLegalizacion;

        return $this;
    }


    public function setCreadoEn(\DateTimeImmutable $creadoEn): static
    {
        $this->creadoEn = $creadoEn;

        return $this;
    }

    public function setActualizadoEn(\DateTimeImmutable $actualizadoEn): static
    {
        $this->actualizadoEn = $actualizadoEn;

        return $this;
    }

    public function getCreadoEn(): ?\DateTimeImmutable
    {
        return $this->creadoEn;
    }

    public function getActualizadoEn(): ?\DateTimeImmutable
    {
        return $this->actualizadoEn;
    }

    public function isInscripcionAutomatica(): ?bool
    {
        return $this->inscripcionAutomatica;
    }

    public function setInscripcionAutomatica(bool $inscripcionAutomatica): static
    {
        $this->inscripcionAutomatica = $inscripcionAutomatica;

        return $this;
    }
}