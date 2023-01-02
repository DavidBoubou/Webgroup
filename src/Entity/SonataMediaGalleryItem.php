<?php

namespace App\Entity;

use App\Repository\SonataMediaGalleryItemRepository;
use Sonata\MediaBundle\Entity\BaseGalleryItem;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="media__gallery_item")
 */
#[ORM\Entity(repositoryClass: SonataMediaGalleryItemRepository::class)]
class SonataMediaGalleryItem extends BaseGalleryItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
