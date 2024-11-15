<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ItemsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemsRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['Items']])]
class Items
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('Items')]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Thumbnail = null;

    #[ORM\Column(length: 255)]
    #[Groups('Items')]
    private ?string $Description = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('Items')]
    private ?Categories $Categorie = null;

    /**
     * @var Collection<int, Loans>
     */
    #[ORM\OneToMany(targetEntity: Loans::class, mappedBy: 'items')]
    private Collection $loan;

    #[ORM\ManyToOne(inversedBy: 'Items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users = null;

    public function __construct()
    {
        $this->loan = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->Thumbnail;
    }

    public function setThumbnail(string $Thumbnail): static
    {
        $this->Thumbnail = $Thumbnail;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->Categorie;
    }

    public function setCategorie(?Categories $Categorie): static
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    /**
     * @return Collection<int, Loans>
     */
    public function getLoan(): Collection
    {
        return $this->loan;
    }

    public function addLoan(Loans $loan): static
    {
        if (!$this->loan->contains($loan)) {
            $this->loan->add($loan);
            $loan->setItems($this);
        }

        return $this;
    }

    public function removeLoan(Loans $loan): static
    {
        if ($this->loan->removeElement($loan)) {
            // set the owning side to null (unless already changed)
            if ($loan->getItems() === $this) {
                $loan->setItems(null);
            }
        }

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
