<?php

namespace App\Entity;

use App\Repository\UserSonataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Sonata\UserBundle\Entity\BaseUser;

#[ORM\Entity(repositoryClass: UserSonataRepository::class)]
#[ORM\Table(name: 'sonata_user__user')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class UserSonata  extends BaseUser 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected  $id = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    protected array $adresse = [];

  // #[ORM\OneToOne(mappedBy: 'autheur', cascade: ['persist', 'remove'])]
  //  protected ?Articles $articles = null;

    #[ORM\Column(type: 'boolean')]
    protected $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'autheur', targetEntity: Articles::class)]
    private Collection $articles;

    //protected ?string $plainPassword = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString():string
    {
        return $this->username;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getAdresse(): array
    {
        return $this->adresse;
    }

    public function setAdresse(?array $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
/*
    public function getArticles(): ?Articles
    {
        return $this->articles;
    }

    public function setArticles(Articles $articles): self
    {
        // set the owning side of the relation if necessary
        if ($articles->getAutheur() !== $this) {
            $articles->setAutheur($this);
        }

        $this->articles = $articles;

        return $this;
    }
*/

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /*
    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $time = null): void
    {
        $this->lastLogin = $time;
    }
    */
    public function setCreatedAt(?\DateTimeInterface $createdAt = null): void
    {
        parent::
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt = null): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setAutheur($this);
        }

        return $this;
    }
/*
    public function prePersist(): void
    {
        //$date = new \DateTime();
        //convert date time to string
        //die($date->format('d/m/Y'));
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }
*/

}
