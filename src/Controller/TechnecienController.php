<?php

namespace App\Controller;

use App\Entity\Technecien;
use App\Form\TechnecienType;
use App\Repository\TechnecienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/technecien')]
class TechnecienController extends AbstractController
{
    #[Route('/', name: 'app_technecien_index', methods: ['GET'])]
    public function index(TechnecienRepository $technecienRepository): Response
    {
        return $this->render('technecien/index.html.twig', [
            'techneciens' => $technecienRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_technecien_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $technecien = new Technecien();
        $form = $this->createForm(TechnecienType::class, $technecien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($technecien);
            $entityManager->flush();

            return $this->redirectToRoute('app_technecien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('technecien/new.html.twig', [
            'technecien' => $technecien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_technecien_show', methods: ['GET'])]
    public function show(Technecien $technecien): Response
    {
        return $this->render('technecien/show.html.twig', [
            'technecien' => $technecien,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_technecien_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Technecien $technecien, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TechnecienType::class, $technecien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_technecien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('technecien/edit.html.twig', [
            'technecien' => $technecien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_technecien_delete', methods: ['POST'])]
    public function delete(Request $request, Technecien $technecien, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$technecien->getId(), $request->request->get('_token'))) {
            $entityManager->remove($technecien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_technecien_index', [], Response::HTTP_SEE_OTHER);
    }
}
