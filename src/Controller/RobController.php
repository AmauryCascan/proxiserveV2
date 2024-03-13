<?php

namespace App\Controller;

use App\Entity\Rob;
use App\Form\RobType;
use App\Repository\RobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rob')]
class RobController extends AbstractController
{
       

    #[Route('/{id}/modifier', name: 'app_rob_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rob $rob, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RobType::class, $rob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories/rob/edit.html.twig', [
            'rob' => $rob,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rob_delete', methods: ['POST'])]
    public function delete(Request $request, Rob $rob, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rob->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rob);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
