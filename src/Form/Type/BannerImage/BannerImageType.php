<?php

declare(strict_types=1);

namespace App\Form\Type\BannerImage;

use App\Entity\BannerImage\BannerImage;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\CoreBundle\Form\Type\ImageType;

final class BannerImageType extends ImageType
{
    public function __construct()
    {
        parent::__construct(BannerImage::class, ['sylius']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->remove('type');
    }

    public function getBlockPrefix(): string
    {
        return 'banner_image';
    }
}