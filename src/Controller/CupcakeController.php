<?php

namespace App\Controller;

use App\Entity\Colors;
use App\Entity\Cupcake;
use App\Form\ColorsType;
use App\Form\CupcakeType;
use App\Entity\Commentary;
use App\Form\CommentaryType;
use App\Repository\CupcakeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CupcakeController extends AbstractController
{
    #[Route('/cupcake/addcupcake', name: 'addcupcake')]
    #[Route('/cupcake/modifycupcake/{id}', name: 'modifycupcake')]
     public function index(Security $security, ?Cupcake $cupcake, ?Colors $colors , Request $request, EntityManagerInterface $entityManager): Response
    {

        if(!$cupcake){
            $cupcake = new Cupcake;
        }

        if(!$colors){
            $colors = new Colors;
        }

        $form = $this->createForm(CupcakeType::class,$cupcake);
        $form->handleRequest($request);

        $formcolors = $this->createForm(ColorsType::class,$colors);
        $formcolors->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            if($cupcake->getUser() !== null) {
                if($security->getUser()->getId() !== $cupcake->getUser()->getId()){
                    $this->addFlash('error', 'Vous ne pouvez pas modifier ce Cupcake');
                     
                    return $this->redirectToRoute('home');
                }
            }
            $cupcake->setUser($security->getUser());
            $entityManager->persist($cupcake);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        if($formcolors->isSubmitted() && $formcolors->isValid()) {

            $entityManager->persist($colors);

            $entityManager->flush();

            $this->addFlash('success', 'Couleur ajouté avec succès');
            
            if($cupcake->getId() !== null) {
                return $this->redirectToRoute('modifycupcake', ['id' => $cupcake->getId()]);
            }
            return $this->redirectToRoute('addcupcake');
        }

        return $this->render('cupcake/addcupcake.html.twig', [
            'form' => $form->createView(), 
            'formcolors' => $formcolors->createView(),
            'isModification' => $cupcake->getId() !== null 
        ]);
    }

    #[Route('/cupcake/deletecupcake/{id}', name: 'deletecupcake')]
    public function remove(Cupcake $cupcake, Request $request, EntityManagerInterface $entityManager)
    {
        
        if($this->isCsrfTokenValid('SUP'.$cupcake->getId(),$request->get('_token'))){
            $entityManager->remove($cupcake);
            $entityManager->flush();
            $this->addFlash('success','La suppression à été effectuée');
            return $this->redirectToRoute('home');
        }
    }

    #[Route('/cupcake/detailscupcake/{id}', name: 'detailscupcake')]
    public function article(Cupcake $cupcake, ?Commentary $commentary, CupcakeRepository $cupcakeRepository, Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        if(!$commentary){
            $commentary = new Commentary;
        }
        // dd($cupcake);
        $form = $this->createForm(CommentaryType::class,$commentary);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $commentary->setUser($security->getUser());
            $commentary->setCupcake($cupcake);

            $entityManager->persist($commentary);
            $entityManager->flush();

            return $this->redirectToRoute('detailscupcake', ['id' => $cupcake->getId()]);
        }

        $cupcake = $cupcakeRepository->findOneBy(['id' => $cupcake->getId()]);
        return $this->render('cupcake/detailscupcake.html.twig', [
            'cupcake' => $cupcake,
            'form' => $form->createView(),
        ]);
    }

}
