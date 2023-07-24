<?php

namespace App\Service;

use Exception;
use App\Service\LanguageService;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class ArtistService
{
    public function __construct(
        private HttpClientInterface $client,
        private ContainerBagInterface $params,
        private LanguageService $languageService
    )
    {
    }

    public function getArtistAbout(array $artist = [], string $local = 'fr_FR'): array {
        $local = $this->languageService->getLanguageCodeOnly($local);

        try {
            if (isset($artist['artistAbouts'])) {
                $artistAbouts = $artist['artistAbouts'];
                usort($artistAbouts, fn($a, $b) => strcmp($a['id'], $b['id']));

                for ($i=0; $i < count($artistAbouts); $i++) { 
                    $artistAbout = $artistAbouts[$i];
                    if ($artistAbout['local']['local'] == $local) {
                        return $artistAbout;
                    }
                }
            }
        } catch (Exception $e) {}
        return [];
    }
}
