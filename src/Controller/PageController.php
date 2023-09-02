<?php

namespace App\Controller;

use App\Repository\Page\PageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends AbstractController
{
    public function __construct(
        private PageRepository $pageRepository,
    ) {}
    
    public function index(string $slug): Response
    {
        $page = $this->pageRepository->findOneBy(['enabled' => true, 'slug' => $slug]);

        if (is_null($page)) {
            throw new NotFoundHttpException('Page not found.');
        }
        
        return $this->render('page/page.html.twig', [
            'page' => $page,
        ]);
    }
}