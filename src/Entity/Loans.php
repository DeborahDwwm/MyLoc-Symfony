<?php

namespace App\Entity;

use App\Repository\LoansRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoansRepository::class)]
class Loans
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_de_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_de_fin = null;

    #[ORM\ManyToOne(inversedBy: 'loan')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Items $items = null;

    #[ORM\ManyToOne(inversedBy: 'Loans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDeDebut(): ?\DateTimeInterface
    {
        return $this->Date_de_debut;
    }

    public function setDateDeDebut(\DateTimeInterface $Date_de_debut): static
    {
        $this->Date_de_debut = $Date_de_debut;

        return $this;
    }

    public function getDateDeFin(): ?\DateTimeInterface
    {
        return $this->Date_de_fin;
    }

    public function setDateDeFin(\DateTimeInterface $Date_de_fin): static
    {
        $this->Date_de_fin = $Date_de_fin;

        return $this;
    }

    public function getItems(): ?Items
    {
        return $this->items;
    }

    public function setItems(?Items $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        $this->users = $users;

        return $this;
    }
}
