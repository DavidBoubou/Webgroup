<?php

namespace App\Entity;

use App\Repository\UserSonataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Sonata\UserBundle\Document\BaseUser;

//#[ORM\Entity(repositoryClass: UserSonataRepository::class)]
#[ORM\Entity]
#[ORM\Table(name: 'sonata_user__user')]
//#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class UserSonata  extends BaseUser // implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    //private ?int $id = null;
    protected  $id;

    #[ORM\Column(length: 180, unique: true)]
    protected ?string $email = null;

    #[ORM\Column]
    protected array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    protected ?string $password = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    protected array $adresse = [];

    #[ORM\OneToOne(mappedBy: 'autheur', cascade: ['persist', 'remove'])]
    protected ?Articles $articles = null;

    #[ORM\Column(type: 'boolean')]
    protected $isVerified = false;

    #[ORM\Column]
    protected ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    protected ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column]
    protected ?\DateTimeInterface $lastLogin = null;

    #[ORM\Column]
    protected ?string $username = null;

    #[ORM\Column(type: 'boolean')]
    protected bool $enabled = false;


    #[ORM\Column]
    protected ?\DateTimeInterface $passwordRequestedAt = null;

    //protected ?string $plainPassword = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;

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

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(?array $roles): void
    {
        $this->roles = $roles;

    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;

    }

    /**
     * @see UserInterface
     *//*
    public function eraseCredentials():void
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
    }
    */

    /**
     * @return mixed
     *//*
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $password): void
    {
        $this->plainPassword = $password;
    }
    */
    public function getAdresse(): array
    {
        return $this->adresse;
    }

    public function setAdresse(?array $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }


}
