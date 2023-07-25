<?php

namespace App\Entity\Faq;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Faq\FaqTranslation;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

#[ORM\Entity()]
class Faq implements ResourceInterface, TranslatableInterface
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

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->getTranslation()->getName();
    }

    public function setName(string $name): static
    {
        $this->getTranslation()->setName($name);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setDescription(string $description): static
    {
        $this->getTranslation()->setDescription($description);

        return $this;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new FaqTranslation();
    }
}
