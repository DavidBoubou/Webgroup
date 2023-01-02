<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\PageBundle\Entity\BaseSite;
use App\Repository\SonataPageSiteRepository;
use Doctrine\DBAL\Types\Types;
/**
 * @ORM\Entity
 * @ORM\Table(name="page__site")
 * @ORM\HasLifecycleCallbacks
 */
#[ORM\Entity(repositoryClass: SonataPageSiteRepository::class)]
class SonataPageSite extends BaseSite
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected $id = null;


    /**
     * @ORM\PrePersist
     */
    public function prePersist(): void
    {
        parent::prePersist();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(): void
    {
        parent::preUpdate();
    }
 
}
