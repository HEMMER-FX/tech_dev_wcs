<?php

namespace App\Controller;

use App\Entity\Argonaute;
use App\Form\ArgonauteType;
use App\Repository\ArgonauteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/argonaute")
 */
class ArgonauteController extends AbstractController
{
    /**
     * @Route("/", name="argonaute_index", methods={"GET"})
     */
    public function index(ArgonauteRepository $argonauteRepository): Response
    {
        return $this->render('argonaute/index.html.twig', [
            'argonautes' => $argonauteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="argonaute_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $argonaute = new Argonaute();
        $form = $this->createForm(ArgonauteType::class, $argonaute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($argonaute);
            $entityManager->flush();

            return $this->redirectToRoute('argonaute_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('argonaute/new.html.twig', [
            'argonaute' => $argonaute,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="argonaute_show", methods={"GET"})
     */
    public function show(Argonaute $argonaute): Response
    {
        return $this->render('argonaute/show.html.twig', [
            'argonaute' => $argonaute,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="argonaute_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Argonaute $argonaute): Response
    {
        $form = $this->createForm(ArgonauteType::class, $argonaute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('argonaute_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('argonaute/edit.html.twig', [
            'argonaute' => $argonaute,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="argonaute_delete", methods={"POST"})
     */
    public function delete(Request $request, Argonaute $argonaute): Response
    {
        if ($this->isCsrfTokenValid('delete'.$argonaute->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($argonaute);
            $entityManager->flush();
        }

        return $this->redirectToRoute('argonaute_index', [], Response::HTTP_SEE_OTHER);
    }
}
