<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Form\EtatType;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/etat')]
class EtatController extends AbstractController
{
    
    
    #[Route('/{id}/modifier', name: 'app_etat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etat $etat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories/etat/edit.html.twig', [
            'etat' => $etat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etat_delete', methods: ['POST'])]
    public function delete(Request $request, Etat $etat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
