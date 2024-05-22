<?php

namespace App\Controller;

use App\Entity\Technecien;
use App\Entity\Intervention;
use App\Entity\Produit;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/reclamation')]
class ReclamationController extends AbstractController // Extend AbstractController
{
    #[Route('/all', name: 'app_reclamation_all', methods: ['GET'])]
    public function all(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
    #[Route('/new/{productId}', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, $productId): Response
    {
        $reclamation = new Reclamation();
        
        // Set the current authenticated user as the owner of the reclamation
        $user = $this->getUser();
        $reclamation->setCodeClt($user);
        
        // Set the current date and time as the creation date and time of the reclamation
        $reclamation->setDateReclamation(new \DateTime());
        
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the reclamation
            $entityManager->persist($reclamation);
            $entityManager->flush();
    
            // Check if there are available technicians
            $availableTechnicians = $entityManager->getRepository(Technecien::class)->findBy(['available' => true]);
    
            if ($availableTechnicians) {
                // Create interventions for available technicians
                foreach ($availableTechnicians as $technician) {
                    $intervention = new Intervention();
                    $intervention->setDateInterv(new \DateTime());
                    $intervention->setStatus(0); // Pending status
                    $intervention->setReclamation($reclamation);
                    $intervention->setCodeTech($technician);
                    $intervention->setCodeClt($user);
        
                    // Update the technician availability
                    $technician->setAvailable(false);
        
                    $entityManager->persist($intervention);
                    $entityManager->persist($technician);
                }
    
                $entityManager->flush();
        
                $this->addFlash('success', 'Thank you for your reclamation. It has been delivered to us. We will send a technician to assist you as soon as possible.');
            } else {
                // If no available technicians, add an informational message
                $this->addFlash('info', 'Thank you for your reclamation. It has been marked as pending until a technician is available.');
            }
        
            return $this->redirectToRoute('app_produit_index'); // Redirect to 'app_produit_index'
        }
            
        return $this->render('reclamation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }




    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index'); // Changed to redirect to 'app_produit_index'
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }





    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produit_index'); // Changed to redirect to 'app_produit_index'
    }



    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
public function index(ReclamationRepository $reclamationRepository): Response
{
    // Fetch all reclamations
    $reclamations = $reclamationRepository->findAll();

    return $this->render('reclamation/index.html.twig', [
        'reclamations' => $reclamations,
    ]);
}
#[Route('/{id}/intervention', name: 'app_reclamation_intervention', methods: ['POST'])]
public function intervention(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): Response
{
    $interventionStatus = $request->request->get('intervention_status');

    // Check if the reclamation has an associated intervention
    if ($reclamation->getIntervention()) {
        if ($interventionStatus === 'complete') {
            // Update the intervention status to complete (1) in the database
            $reclamation->getIntervention()->setStatus(1);
            $entityManager->persist($reclamation->getIntervention()); // Persist the updated intervention
            
            // Set the technician's availability to 1 (available)
            $technician = $reclamation->getIntervention()->getCodeTech();
            $technician->setAvailable(1);
            $entityManager->persist($technician); // Persist the updated technician
            
            $entityManager->flush();
        }
    } else {
        // Handle the case where there is no associated intervention
        // You can add a flash message or handle this situation according to your application's logic
    }

    // Generate the URL for the user's profile page
// Generate the URL for the user's profile page
$profileUrl = $urlGenerator->generate('app_user_show', ['id' => $reclamation->getCodeClt()->getId()]);
    
    // Return a RedirectResponse to the user's profile page
    return new RedirectResponse($profileUrl);
}


}