<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie_id = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $ordonnance = null;

    #[ORM\OneToOne(mappedBy: 'produit_id', cascade: ['persist', 'remove'])]
    private ?Stock $stock = null;

    #[ORM\ManyToMany(targetEntity: TailleCommande::class, mappedBy: 'produit_id')]
    private Collection $tailleCommandes;

    #[ORM\ManyToMany(targetEntity: TailleAchat::class, mappedBy: 'produit_id')]
    private Collection $tailleAchats;

    public function __construct()
    {
        $this->tailleCommandes = new ArrayCollection();
        $this->tailleAchats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCategorieId(): ?Categorie
    {
        return $this->categorie_id;
    }

    public function setCategorieId(?Categorie $categorie_id): self
    {
        $this->categorie_id = $categorie_id;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function isOrdonnance(): ?bool
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(bool $ordonnance): self
    {
        $this->ordonnance = $ordonnance;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): self
    {
        // set the owning side of the relation if necessary
        if ($stock->getProduitId() !== $this) {
            $stock->setProduitId($this);
        }

        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, TailleCommande>
     */
    public function getTailleCommandes(): Collection
    {
        return $this->tailleCommandes;
    }

    public function addTailleCommande(TailleCommande $tailleCommande): self
    {
        if (!$this->tailleCommandes->contains($tailleCommande)) {
            $this->tailleCommandes->add($tailleCommande);
            $tailleCommande->addProduitId($this);
        }

        return $this;
    }

    public function removeTailleCommande(TailleCommande $tailleCommande): self
    {
        if ($this->tailleCommandes->removeElement($tailleCommande)) {
            $tailleCommande->removeProduitId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TailleAchat>
     */
    public function getTailleAchats(): Collection
    {
        return $this->tailleAchats;
    }

    public function addTailleAchat(TailleAchat $tailleAchat): self
    {
        if (!$this->tailleAchats->contains($tailleAchat)) {
            $this->tailleAchats->add($tailleAchat);
            $tailleAchat->addProduitId($this);
        }

        return $this;
    }

    public function removeTailleAchat(TailleAchat $tailleAchat): self
    {
        if ($this->tailleAchats->removeElement($tailleAchat)) {
            $tailleAchat->removeProduitId($this);
        }

        return $this;
    }
}
