<?php

namespace App\Controller;

use App\Service\ApiService;
use App\Service\ArtistService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Bundle\TaxonomyBundle\Doctrine\ORM\TaxonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    public function __construct(
        private TaxonRepository $taxonRepository,
    ) {
    }
    
    public function index(Request $request): Response
    {
        $taxon = $this->taxonRepository->findOneBy(['code' => 'MENU_CATEGORY']);
        $parameters = $request->query->all();

        if ($taxon) {
            $parameters['slug'] = $taxon->getSlug();
            return $this->redirectToRoute('sylius_shop_product_index', $parameters);
        } else {
            return $this->render('page/search.html.twig', [
                
            ]);
        }
    }
}