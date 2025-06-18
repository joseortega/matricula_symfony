<?php

namespace App\Entity;

use App\Repository\EstudianteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EstudianteRepository::class)]
#[ORM\HasLifecycleCallbacks] // ¡Este atributo es crucial!
class Estudiante
{
    public const SEXO_HOMBRE = 'HOMBRE';
    public const SEXO_MUJER = 'MUJER';

    public const SEXOS  = [self::SEXO_HOMBRE, self::SEXO_MUJER];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[Assert\NotBlank]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $identificacion = null;
    
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $apellidos = null;
    
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $nombres = null;
    
    #[Assert\NotBlank]
    #[Assert\Choice(self::SEXOS)]
    #[ORM\Column(length: 255)]
    private ?string $sexo = null;
    
    #[Assert\NotBlank]
    #[Type("DateTime<'Y-m-d'>")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    #[Assert\NotNull]
    #[ORM\ManyToOne(inversedBy: 'estudiantes')]
    private ?Nacionalidad $nacionalidad = null;
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $direccion = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefono = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $correo = null;
    
    #[ORM\Column]
    private ?bool $tieneDiscapacidad = false;
    
    #[ORM\ManyToOne(inversedBy: 'estudiantes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?UniformeTalla $uniformeTalla = null;

    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'estudiante', targetEntity: Matricula::class)]
    private Collection $matriculas;

    /**
     * @var Collection<int, EstudianteRepresentante>
     */
    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'estudiante', targetEntity: EstudianteRepresentante::class, orphanRemoval: true)]
    private Collection $estudianteRepresentantes;

    #[Exclude()]
    #[ORM\OneToOne(mappedBy: 'estudiante', cascade: ['persist', 'remove'])]
    private ?Expediente $expediente = null;


    public function __construct()
    {
        $this->matriculas = new ArrayCollection();
        $this->estudianteRepresentantes = new ArrayCollection();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function normalizeNames(): void
    {
        $this->nombres = mb_strtoupper($this->nombres, 'UTF-8');
        $this->apellidos = mb_strtoupper($this->apellidos, 'UTF-8');
        $this->direccion = mb_strtoupper($this->direccion, 'UTF-8');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentificacion(): ?string
    {
        return $this->identificacion;
    }

    public function setIdentificacion(string $identificacion): static
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): static
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): static
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getSexo(): ?string
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo): static
    {
        $this->sexo = $sexo;

        return $this;
    }
    
    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }
    
    public function getNacionalidad(): ?Nacionalidad
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad(?Nacionalidad $nacionalidad): static
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }
    
    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }
    
    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): static
    {
        $this->correo = $correo;

        return $this;
    }
    
    public function isTieneDiscapacidad(): ?bool
    {
        return $this->tieneDiscapacidad;
    }

    public function setTieneDiscapacidad(bool $tieneDiscapacidad): static
    {
        $this->tieneDiscapacidad = $tieneDiscapacidad;

        return $this;
    }
    
    public function getUniformeTalla(): ?UniformeTalla
    {
        return $this->uniformeTalla;
    }

    public function setUniformeTalla(?UniformeTalla $uniformeTalla): static
    {
        $this->uniformeTalla = $uniformeTalla;

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
            $matricula->setEstudiante($this);
        }

        return $this;
    }

    public function removeMatricula(Matricula $matricula): static
    {
        if ($this->matriculas->removeElement($matricula)) {
            // set the owning side to null (unless already changed)
            if ($matricula->getEstudiante() === $this) {
                $matricula->setEstudiante(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EstudianteRepresentante>
     */
    public function getEstudianteRepresentantes(): Collection
    {
        return $this->estudianteRepresentantes;
    }

    public function addEstudianteRepresentante(EstudianteRepresentante $estudianteRepresentante): static
    {
        if (!$this->estudianteRepresentantes->contains($estudianteRepresentante)) {
            $this->estudianteRepresentantes->add($estudianteRepresentante);
            $estudianteRepresentante->setEstudiante($this);
        }

        return $this;
    }

    public function removeEstudianteRepresentante(EstudianteRepresentante $estudianteRepresentante): static
    {
        if ($this->estudianteRepresentantes->removeElement($estudianteRepresentante)) {
            // set the owning side to null (unless already changed)
            if ($estudianteRepresentante->getEstudiante() === $this) {
                $estudianteRepresentante->setEstudiante(null);
            }
        }

        return $this;
    }

    public function getExpediente(): ?Expediente
    {
        return $this->expediente;
    }

    public function setExpediente(Expediente $expediente): static
    {
        // set the owning side of the relation if necessary
        if ($expediente->getEstudiante() !== $this) {
            $expediente->setEstudiante($this);
        }

        $this->expediente = $expediente;

        return $this;
    }

    public function __toString() {
        return  $this->getApellidos().' '.$this->getNombres();
    }

}
