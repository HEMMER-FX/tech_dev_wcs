<?php

namespace App\Controller;

use App\Entity\Argonaute;
use App\Form\ArgonauteType;
use App\Repository\ArgonauteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, ArgonauteRepository $argonauteRepository): Response

    {
        $argonaute = new Argonaute();
        $form = $this->createForm(ArgonauteType::class, $argonaute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($argonaute);
            $entityManager->flush();

        }

        $allArgo = $argonauteRepository->findAll();

        return $this->render('home/index.html.twig', [
            'argonaute' => $argonaute,
            'allArgo' => $allArgo,
            'form' => $form->createView(),
        ]);
    }
}
