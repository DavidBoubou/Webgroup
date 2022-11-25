<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
final class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $baniere_url = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(nullable: true)]
    private ?bool $publie = null;

    #[ORM\OneToMany(mappedBy: 'articles', targetEntity: Categories::class)]
    private Collection $catégorie;

    #[ORM\OneToOne(inversedBy: 'articles', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $autheur = null;

    public function __construct()
    {
        $this->catégorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getBaniereUrl(): ?string
    {
        return $this->baniere_url;
    }

    public function setBaniereUrl(?string $baniere_url): self
    {
        $this->baniere_url = $baniere_url;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isPublie(): ?bool
    {
        return $this->publie;
    }

    public function setPublie(?bool $publie): self
    {
        $this->publie = $publie;

        return $this;
    }

    /**
     * @return Collection<int, categories>
     */
    public function getCatégorie(): Collection
    {
        return $this->catégorie;
    }

    public function addCatGorie(categories $catGorie): self
    {
        if (!$this->catégorie->contains($catGorie)) {
            $this->catégorie->add($catGorie);
            $catGorie->setArticles($this);
        }

        return $this;
    }

    public function removeCatGorie(categories $catGorie): self
    {
        if ($this->catégorie->removeElement($catGorie)) {
            // set the owning side to null (unless already changed)
            if ($catGorie->getArticles() === $this) {
                $catGorie->setArticles(null);
            }
        }

        return $this;
    }

    public function getAutheur(): ?User
    {
        return $this->autheur;
    }

    public function setAutheur(User $autheur): self
    {
        $this->autheur = $autheur;

        return $this;
    }
}
