<?php

namespace App\Controller;

use App\Entity\File;
use DateTimeImmutable;
use App\Entity\Comment;
use App\Entity\Travaux;
use App\Form\MyFileType;
use App\Form\CommentType;
use App\Form\TravauxType;
use App\Form\TravauxShowType;
use App\Repository\TravauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/travaux')]
class TravauxController extends AbstractController
{
    #[Route('/', name: 'app_travaux_index', methods: ['GET'])]
    public function index(TravauxRepository $travauxRepository): Response
    {
        
        return $this->render('travaux/index.html.twig', [
            'travauxList' => $travauxRepository->findAllEnCours(['FACTURE','TERMINE', 'ANNULE']),
        ]);
    }

    #[Route('/facture', name: 'app_travaux_facture', methods: ['GET'])]
    public function facture(TravauxRepository $travauxRepository): Response
    {     

        return $this->render('travaux/facture.html.twig', [
            'travauxList' => $travauxRepository->findAllwithFacture('FACTURE', 'TERMINE'),
        ]);
    }

    #[Route('/annule', name: 'app_travaux_annule', methods: ['GET'])]
    public function annule(TravauxRepository $travauxRepository): Response
    {     

        return $this->render('travaux/facture.html.twig', [
            'travauxList' => $travauxRepository->findAllAnnule('ANNULE'),
        ]);
    }

    #[Route('/robinetterie', name: 'app_travaux_robinetterie', methods: ['GET'])]
    public function robinetterie(TravauxRepository $travauxRepository): Response
    {
        
        return $this->render('travaux/robinetterie.html.twig', [
            'travauxList' => $travauxRepository->findWithRobs(),
        ]);
    }

    #[Route('/nouveau', name: 'app_travaux_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $travaux = new Travaux();
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($travaux);
            $entityManager->flush();

            $file = $form->get('file')->getData();

            // Vérifiez si un fichier a été téléchargé
            if ($file) {
                $newFilename = uniqid() . '.' . $file->guessExtension();
                
                // Déplacez le fichier vers le dossier de destination
                $file->move('images_bt', $newFilename);
        
                // Créez un nouvel objet pour stocker le nom de fichier et l'ID du travail associé
                $fileEntity = new File();
                
                $fileEntity->setFilename($newFilename);
                $fileEntity->setTravaux($travaux);
                
                // Persistez et sauvegardez l'objet $fileEntity dans la base de données
                $entityManager->persist($fileEntity);
                $entityManager->flush();   
            }
           

            return $this->redirectToRoute('app_travaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('travaux/new.html.twig', [
            'travaux' => $travaux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_travaux_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Travaux $travaux, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        /** @var \App\Entity\User $user */
        $dateTime = new DateTimeImmutable();

        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            
            $user->addComment($comment);
            $travaux->addComment($comment);
            $comment->setPublishedAt($dateTime);            
            $entityManager->persist($comment);
                        
            $entityManager->flush();
           
            $referer = $request->headers->get("referer");

            return $this->redirect($referer);
        }

        $formShow = $this->createForm(TravauxShowType::class, $travaux);
        $formShow->handleRequest($request);

        if ($formShow->isSubmitted() && $formShow->isValid()) {
                        
            $entityManager->persist($travaux);

            
            $entityManager->flush();
           
            $referer = $request->headers->get("referer");

            return $this->redirect($referer);
        }

        
        $formFile = $this->createForm(MyFileType::class);
        $formFile->handleRequest($request);

        if ($formFile->isSubmitted() && $formFile->isValid()) {

            $file = $formFile->get('file')->getData();
            
            if ($file) {
                $newFilename = uniqid() . '.' . $file->guessExtension();
                
                // Déplacez le fichier vers le dossier de destination
                $file->move('images_bt', $newFilename);
        
                // Créez un nouvel objet pour stocker le nom de fichier et l'ID du travail associé
                $fileEntity = new File();
                
                $fileEntity->setFilename($newFilename);
                
                $fileEntity->setTravaux($travaux);
                
                // Persistez et sauvegardez l'objet $fileEntity dans la base de données
                $entityManager->persist($fileEntity);        
            }
            $entityManager->flush();
           
            $referer = $request->headers->get("referer");

            return $this->redirect($referer);
        }

        return $this->render('travaux/show.html.twig', [
            'travaux' => $travaux,
            'formComment' => $formComment,
            'formShow' => $formShow,
            'formFile' => $formFile,
            'user' => $user = $this->getUser(),
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_travaux_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Travaux $travaux, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TravauxType::class, $travaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_travaux_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('travaux/edit.html.twig', [
            'travaux' => $travaux,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_travaux_delete', methods: ['POST'])]
    public function delete(Request $request, Travaux $travaux, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$travaux->getId(), $request->request->get('_token'))) {
            $entityManager->remove($travaux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_travaux_index', [], Response::HTTP_SEE_OTHER);
    }
}
