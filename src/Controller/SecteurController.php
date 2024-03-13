<?php

namespace App\Controller;

use App\Entity\Secteur;
use App\Form\SecteurType;
use App\Repository\SecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/secteur')]
class SecteurController extends AbstractController
{
    

    #[Route('/{id}/modifier', name: 'app_secteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Secteur $secteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SecteurType::class, $secteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories/secteur/edit.html.twig', [
            'secteur' => $secteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_secteur_delete', methods: ['POST'])]
    public function delete(Request $request, Secteur $secteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$secteur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($secteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
