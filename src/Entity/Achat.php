<?php

namespace App\Entity;

use App\Repository\AchatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AchatRepository::class)]
class Achat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $num_achat = null;

    #[ORM\ManyToOne(inversedBy: 'achats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseur $fournisseur_id = null;

    #[ORM\Column]
    private ?int $TVA = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'achat_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TailleAchat $tailleAchat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumAchat(): ?int
    {
        return $this->num_achat;
    }

    public function setNumAchat(int $num_achat): self
    {
        $this->num_achat = $num_achat;

        return $this;
    }

    public function getFournisseurId(): ?Fournisseur
    {
        return $this->fournisseur_id;
    }

    public function setFournisseurId(?Fournisseur $fournisseur_id): self
    {
        $this->fournisseur_id = $fournisseur_id;

        return $this;
    }

    public function getTVA(): ?int
    {
        return $this->TVA;
    }

    public function setTVA(int $TVA): self
    {
        $this->TVA = $TVA;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTailleAchat(): ?TailleAchat
    {
        return $this->tailleAchat;
    }

    public function setTailleAchat(?TailleAchat $tailleAchat): self
    {
        $this->tailleAchat = $tailleAchat;

        return $this;
    }
}
