<?php

namespace App\Entity;

use App\Repository\TailleAchatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TailleAchatRepository::class)]
class TailleAchat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'tailleAchat', targetEntity: Achat::class)]
    private Collection $achat_id;

    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'tailleAchats')]
    private Collection $produit_id;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prix = null;

    public function __construct()
    {
        $this->achat_id = new ArrayCollection();
        $this->produit_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Achat>
     */
    public function getAchatId(): Collection
    {
        return $this->achat_id;
    }

    public function addAchatId(Achat $achatId): self
    {
        if (!$this->achat_id->contains($achatId)) {
            $this->achat_id->add($achatId);
            $achatId->setTailleAchat($this);
        }

        return $this;
    }

    public function removeAchatId(Achat $achatId): self
    {
        if ($this->achat_id->removeElement($achatId)) {
            // set the owning side to null (unless already changed)
            if ($achatId->getTailleAchat() === $this) {
                $achatId->setTailleAchat(null);
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
