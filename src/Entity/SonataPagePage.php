<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\PageBundle\Entity\BasePage;
use Doctrine\DBAL\Types\Types;
use App\Repository\SonataPagePageRepository;

/**
 * @ORM\Entity
 * @ORM\Table(name="page__page")
 */
#[ORM\Entity(repositoryClass: SonataPagePageRepository::class)]
class SonataPagePage extends BasePage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    protected $id = null;
}
