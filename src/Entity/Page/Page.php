<?php

namespace App\Entity\Page;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Page\PageTranslation;
use App\Repository\Page\PageRepository;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page implements ResourceInterface, TranslatableInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->enabled = true;
    }
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $enabled = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setContent(string $content): static
    {
        $this->getTranslation()->setContent($content);
    }

    public function getContent(): ?string
    {
        return $this->getTranslation()->getContent();
    }

    public function setSlug(string $slug): static
    {
        $this->getTranslation()->setSlug($slug);
    }

    public function getSlug(): ?string
    {
        return $this->getTranslation()->getSlug();
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new PageTranslation();
    }
}
