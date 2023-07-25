<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\BannerImage\BannerImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BannerImageController extends AbstractController
{
    public function __construct(
        private BannerImageRepository $bannerImageRepository,
    ) {}
    
    public function getImages(): Response
    {
        $images = $this->bannerImageRepository->findBy([], ['id' => 'DESC']);
        
        return $this->render('page/Homepage/_images.html.twig', [
            'images' => $images,
        ]);
    }
}