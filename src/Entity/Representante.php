<?php

namespace App\Entity;

use App\Repository\RepresentanteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RepresentanteRepository::class)]
class Representante
{
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
    
    #[Type("DateTime<'Y-m-d'>")]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaNacimiento = null;
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $direccion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telefono = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $correo = null;

    /**
     * @var Collection<int, EstudianteRepresentante>
     */
    #[Exclude()]
    #[ORM\OneToMany(mappedBy: 'representante', targetEntity: EstudianteRepresentante::class, orphanRemoval: true)]
    private Collection $estudianteRepresentantes;

   
    public function __construct()
    {
        $this->estudiantes = new ArrayCollection();
        $this->estudianteRepresentantes = new ArrayCollection();
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
    
    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): static
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

    public function setCorreo(?string $correo): static
    {
        $this->correo = $correo;

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
            $estudianteRepresentante->setRepresentante($this);
        }

        return $this;
    }

    public function removeEstudianteRepresentante(EstudianteRepresentante $estudianteRepresentante): static
    {
        if ($this->estudianteRepresentantes->removeElement($estudianteRepresentante)) {
            // set the owning side to null (unless already changed)
            if ($estudianteRepresentante->getRepresentante() === $this) {
                $estudianteRepresentante->setRepresentante(null);
            }
        }

        return $this;
    }
    
    public function __toString() {
        return $this->getApellidos().' '.$this->getNombres();
        
    }
}
