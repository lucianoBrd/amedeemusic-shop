<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FaqController extends AbstractController
{
    public function __construct(
    ) {
    }
    
    public function index(): Response
    {
        return $this->render('page/faq.html.twig', [
            
        ]);
    }
}