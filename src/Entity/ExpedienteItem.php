<?php

namespace App\Entity;

use App\Repository\ExpedienteItemRepository;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExpedienteItemRepository::class)]
class ExpedienteItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'expedienteItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Expediente $expediente = null;

    #[ORM\ManyToOne(inversedBy: 'expedienteItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Requisito $requisito = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpediente(): ?Expediente
    {
        return $this->expediente;
    }

    public function setExpediente(?Expediente $expediente): static
    {
        $this->expediente = $expediente;

        return $this;
    }

    public function getRequisito(): ?Requisito
    {
        return $this->requisito;
    }

    public function setRequisito(?Requisito $requisito): static
    {
        $this->requisito = $requisito;

        return $this;
    }
}
