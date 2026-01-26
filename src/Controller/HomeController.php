<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\CupcakeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CupcakeRepository $cupcakeRepository): Response
    {

        $cupcake = $cupcakeRepository->findFour();
        return $this->render('home/home.html.twig', [
            "cupcake" => $cupcake,
        ]);
    }

    #[Route('/museum', name: 'museum')]
    public function galerie(CupcakeRepository $cupcakeRepository): Response
    {   
        $cupcake = $cupcakeRepository->findAll();
        return $this->render('home/museum.html.twig', [
            "cupcake" => $cupcake,
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        $data = $form->getData();

        $email= (new Email())
            ->from($form->get('email')->getData())
            ->to('admin@admin.fr')
            ->subject('Contact depuis le site Musée du Cupcake')
            ->text(
                "Nom: {$data['name']}\n".
                "Email: {$data['email']}\n\n".
                "Message: {$data['message']}\n"
            );
            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('contact');
        }

        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}