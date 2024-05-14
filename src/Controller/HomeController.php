<?php
// src/Controller/HomeController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        // Here you can render the homepage template or perform any other logic
        return $this->render('home/index.html.twig');
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