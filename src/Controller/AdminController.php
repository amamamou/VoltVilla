<?php
// src/Controller/AdminController.php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\InterventionRepository;
use App\Repository\ReclamationRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TechnecienRepository;

class AdminController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(
        UserRepository $userRepository,
        InterventionRepository $interventionRepository,
        ReclamationRepository $reclamationRepository,
        ProduitRepository $produitRepository,
        TechnecienRepository $technicianRepository
    ): Response {
        // Fetch the counts from your repositories
        $userCount = $userRepository->count([]);
        $interventionCount = $interventionRepository->count([]);
        $reclamationCount = $reclamationRepository->count([]);
        $productCount = $produitRepository->count([]);
        $technicianCount = $technicianRepository->countTechnicians(); // Use the new method to count technicians

        // Render the dashboard template with the counts
        return $this->render('admin/dashboard/dashboard.html.twig', [
            'userCount' => $userCount,
            'interventionCount' => $interventionCount,
            'reclamationCount' => $reclamationCount,
            'productCount' => $productCount,
            'technicianCount' => $technicianCount,
        ]);
    }
}
