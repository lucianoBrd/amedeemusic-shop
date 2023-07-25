<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Webmozart\Assert\Assert;
use App\Entity\BannerImage\BannerImageInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ImageUploadSubscriber implements EventSubscriberInterface
{
    public function __construct(private ImageUploaderInterface $uploader)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'app.banner_image.pre_create' => 'uploadImage',
            'app.banner_image.pre_update' => 'uploadImage',
        ];
    }

    public function uploadImage(GenericEvent $event): void
    {
        $subject = $event->getSubject();

        Assert::isInstanceOf($subject, BannerImageInterface::class);

        $this->uploadSubjectImage($subject);
    }

    private function uploadSubjectImage(BannerImageInterface $subject): void
    {
        if ($subject->hasFile()) {
            $this->uploader->upload($subject);
        }

        // Remove image if upload failed
        if (null === $subject->getPath()) {
            $subject->setFile(null);
        }
    }
}