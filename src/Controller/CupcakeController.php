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
                return $this->redirectToRoute('Cupcake_modify', ['id' => $cupcake->getId()]);
            }
            return $this->redirectToRoute('addcupcake');
        }

        return $this->render('Cupcake/addcupcake.html.twig', [
            'form' => $form->createView(), 
            'formcolors' => $formcolors->createView(),
            'isModification' => $cupcake->getId() !== null 
        ]);
    }

    #[Route('/Cupcake/deletecupcake/{id}', name: 'deletecupcake')]
    public function remove(Cupcake $Cupcake, Request $request, EntityManagerInterface $entityManager)
    {
        
        if($this->isCsrfTokenValid('SUP'.$Cupcake->getId(),$request->get('_token'))){
            $entityManager->remove($Cupcake);
            $entityManager->flush();
            $this->addFlash('success','La suppression à été effectuée');
            return $this->redirectToRoute('home');
        }
    }

    #[Route('/Cupcake/detailscupcake/{id}', name: 'detailscupcake')]
    public function article(Cupcake $Cupcake, ?Commentary $commentary, CupcakeRepository $CupcakeRepository, Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        if(!$commentary){
            $commentary = new Commentary;
        }
        
        $form = $this->createForm(CommentaryType::class,$commentary);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $commentary->setUser($security->getUser());
            $commentary->setCupcake($Cupcake);

            $entityManager->persist($commentary);
            $entityManager->flush();

            return $this->redirectToRoute('detailscupcake', ['id' => $Cupcake->getId()]);
        }

        $Cupcake = $CupcakeRepository->findOneBy(['id' => $Cupcake->getId()]);
        return $this->render('cupcake/detailscupcake.html.twig', [
            'Cupcake' => $Cupcake,
            'form' => $form->createView(),
        ]);
    }

}
