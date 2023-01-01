<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Sonata\PageBundle\Entity\BasePage;
use Sonata\PageBundle\Model\Page;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles extends BasePage //Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    //private ?int $id = null;
    protected  $id ;

    //My custom field
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $baniere_url = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'articles', targetEntity: Categories::class)]
    private Collection $categorie;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?User $autheur = null;


    public function __construct()
    {
        $this->categorie = new ArrayCollection();
    }

    public function __toString():string
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setIdOnNull():self
    {
        $this->id = null;
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

    public function getbaniere_url(): ?string
    {
        return $this->baniere_url;
    }

    public function setbaniere_url(?string $baniere_url): self
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

    /**
     * @return Collection<int, categories>
     */
   public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCatGorie(categories $catGorie): self
    {
        if (!$this->categorie->contains($catGorie)) {
            $this->categorie->add($catGorie);
            $catGorie->setArticles($this);
        }

        return $this;
    }

    public function removeCatGorie(categories $catGorie): self
    {
        if ($this->categorie->removeElement($catGorie)) {
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

    public function setAutheur(?User $autheur): self
    {
        $this->autheur = $autheur;

        return $this;
    }
    
}