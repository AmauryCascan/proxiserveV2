<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Rob;
use App\Entity\Secteur;
use App\Entity\Type;
use App\Form\EtatType;
use App\Form\RobType;
use App\Form\SecteurType;
use App\Form\TypeType;
use App\Repository\RobRepository;
use App\Repository\EtatRepository;
use App\Repository\TypeRepository;
use App\Repository\SecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/categories')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'app_categories_index', methods: ['GET', 'POST'])]
    public function index(EtatRepository $etatRepository, TypeRepository $typeRepository, SecteurRepository $secteurRepository, 
                            RobRepository $robRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $etat = new Etat();
        $type = new Type();
        $secteur = new Secteur();
        $rob = new Rob();


        $formEtat = $this->createForm(EtatType::class, $etat);
        $formType = $this->createForm(TypeType::class, $type);
        $formSecteur = $this->createForm(SecteurType::class, $secteur);
        $formRob = $this->createForm(RobType::class, $rob);


        $formEtat->handleRequest($request);
        $formType->handleRequest($request);
        $formSecteur->handleRequest($request);
        $formRob->handleRequest($request);

        if ($formEtat->isSubmitted() && $formEtat->isValid()) {
            
                        
            $entityManager->persist($etat);
                        
            $entityManager->flush();
           
            $referer = $request->headers->get("referer");

            return $this->redirect($referer);
        }
        if ($formType->isSubmitted() && $formType->isValid()) {
            
                        
            $entityManager->persist($type);
                        
            $entityManager->flush();
           
            $referer = $request->headers->get("referer");

            return $this->redirect($referer);
        }
        if ($formSecteur->isSubmitted() && $formSecteur->isValid()) {
            
                        
            $entityManager->persist($secteur);
                        
            $entityManager->flush();
           
            $referer = $request->headers->get("referer");

            return $this->redirect($referer);
        }
        if ($formRob->isSubmitted() && $formRob->isValid()) {
            
                        
            $entityManager->persist($rob);
                        
            $entityManager->flush();
           
            $referer = $request->headers->get("referer");

            return $this->redirect($referer);
        }


        return $this->render('categories/index.html.twig', [
            'etats' => $etatRepository->findAll(),
            'types' => $typeRepository->findAll(),
            'secteurs' => $secteurRepository->findAll(),
            'robs' => $robRepository->findAll(),
            'formEtat' => $formEtat,
            'formType' => $formType,
            'formSecteur' => $formSecteur,
            'formRob' => $formRob, 
         ]);
    }
}    