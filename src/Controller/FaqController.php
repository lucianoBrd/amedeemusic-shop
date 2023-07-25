<?php

namespace App\Controller;

use App\Repository\Faq\FaqRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FaqController extends AbstractController
{
    public function __construct(
        private FaqRepository $faqRepository,
    ) {}
    
    public function index(): Response
    {
        $faqs = $this->faqRepository->findBy(['enabled' => true], ['id' => 'ASC']);
        
        return $this->render('page/faq.html.twig', [
            'faqs' => $faqs,
        ]);
    }
}