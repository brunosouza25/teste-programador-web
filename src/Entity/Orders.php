<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 9)]
    private ?string $cep = null;

    #[ORM\Column(length: 255)]
    private ?string $delivery_neighborhood = null;

    #[ORM\Column(length: 255)]
    private ?string $delivery_city = null;

    #[ORM\Column(length: 255)]
    private ?string $delivery_uf = null;

    #[ORM\Column(length: 255)]
    private ?string $delivery_street = null;

    #[ORM\Column(length: 512)]
    private ?string $delivery_observations = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCep(): ?string
    {
        return $this->cep;
    }

    public function setCep(string $cep): static
    {
        $this->cep = $cep;

        return $this;
    }

    public function getDeliveryNeighborhood(): ?string
    {
        return $this->delivery_neighborhood;
    }

    public function setDeliveryNeighborhood(string $delivery_neighborhood): static
    {
        $this->delivery_neighborhood = $delivery_neighborhood;

        return $this;
    }

    public function getDeliveryCity(): ?string
    {
        return $this->delivery_city;
    }

    public function setDeliveryCity(string $delivery_city): static
    {
        $this->delivery_city = $delivery_city;

        return $this;
    }

    public function getDeliveryUf(): ?string
    {
        return $this->delivery_uf;
    }

    public function setDeliveryUf(string $delivery_uf): static
    {
        $this->delivery_uf = $delivery_uf;

        return $this;
    }

    public function getDeliveryStreet(): ?string
    {
        return $this->delivery_street;
    }

    public function setDeliveryStreet(string $delivery_street): static
    {
        $this->delivery_street = $delivery_street;

        return $this;
    }

    public function getDeliveryObservations(): ?string
    {
        return $this->delivery_observations;
    }

    public function setDeliveryObservations(string $delivery_observations): static
    {
        $this->delivery_observations = $delivery_observations;

        return $this;
    }
}
