<?php

namespace App\Entity;

use App\Repository\TailleCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TailleCommandeRepository::class)]
class TailleCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'tailleCommande', targetEntity: Commande::class)]
    private Collection $commande_id;

    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'tailleCommandes')]
    private Collection $produit_id;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prix = null;

    public function __construct()
    {
        $this->commande_id = new ArrayCollection();
        $this->produit_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandeId(): Collection
    {
        return $this->commande_id;
    }

    public function addCommandeId(Commande $commandeId): self
    {
        if (!$this->commande_id->contains($commandeId)) {
            $this->commande_id->add($commandeId);
            $commandeId->setTailleCommande($this);
        }

        return $this;
    }

    public function removeCommandeId(Commande $commandeId): self
    {
        if ($this->commande_id->removeElement($commandeId)) {
            // set the owning side to null (unless already changed)
            if ($commandeId->getTailleCommande() === $this) {
                $commandeId->setTailleCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduitId(): Collection
    {
        return $this->produit_id;
    }

    public function addProduitId(Produit $produitId): self
    {
        if (!$this->produit_id->contains($produitId)) {
            $this->produit_id->add($produitId);
        }

        return $this;
    }

    public function removeProduitId(Produit $produitId): self
    {
        $this->produit_id->removeElement($produitId);

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

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
}
