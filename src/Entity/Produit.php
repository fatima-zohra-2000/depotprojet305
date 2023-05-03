<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[Vich\Uploadable]
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


    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;


    #[ORM\Column]
    private ?bool $ordonnance = null;

    #[ORM\OneToOne(mappedBy: 'produit_id', cascade: ['persist', 'remove'])]
    private ?Stock $stock = null;

    #[ORM\ManyToMany(targetEntity: TailleCommande::class, mappedBy: 'produit_id')]
    private Collection $tailleCommandes;

    #[ORM\ManyToMany(targetEntity: TailleAchat::class, mappedBy: 'produit_id')]
    private Collection $tailleAchats;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
