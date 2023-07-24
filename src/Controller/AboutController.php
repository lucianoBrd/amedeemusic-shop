<?php

namespace App\Controller;

use App\Service\ApiService;
use App\Service\ArtistService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    public function __construct(
        private ApiService $apiService,
        private ArtistService $artistService,
    ) {
    }
    
    public function index(Request $request): Response
    {
        $locale = $request->getLocale();

        $artist = $this->apiService->get('/api/artists/last');
        $artistAbout = $this->artistService->getArtistAbout($artist, $locale);

        return $this->render('page/about.html.twig', [
            'artistAbout' => $artistAbout,
            'artist' => $artist,
        ]);
    }
}