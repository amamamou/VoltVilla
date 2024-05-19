<?php
// src/Controller/HomeController.php

// src/Controller/HomeController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TechnecienRepository; // Ensure you have this repository

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(TechnecienRepository $technecienRepository): Response
    {
        $techneciens = $technecienRepository->findAll();

        return $this->render('home/index.html.twig', [
            'techneciens' => $techneciens,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        // Logic for about page
        return $this->render('home/about.html.twig');
    }

    // Add other routes as needed...
}
