<?php

namespace App\Entity\BannerImage;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Image;
use App\Entity\BannerImage\BannerImageInterface;
use App\Repository\BannerImage\BannerImageRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BannerImageRepository::class)]
class BannerImage extends Image implements BannerImageInterface
{
    #[Assert\Image(groups: ['sylius'])] // configure the options according to your needs
    protected $file;

    public function __construct()
    {
        $this->type = 'default';
    }
}
