<?php

namespace App\Controller;

use App\Entity\Abonnement2;
use App\Form\Abonnement2Type;
use App\Repository\AbonnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/abonnement2")
 */
class Abonnement2Controller extends AbstractController
{
    /**
     * @Route("/", name="abonnement2_index", methods={"GET"})
     */
    public function index(AbonnementRepository $abonnementRepository): Response
    {
        return $this->render('abonnement2/index.html.twig', [
            'abonnement2s' => $abonnementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="abonnement2_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $abonnement2 = new Abonnement2();
        $form = $this->createForm(Abonnement2Type::class, $abonnement2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($abonnement2);
            $entityManager->flush();

            return $this->redirectToRoute('abonnement2_index');
        }

        return $this->render('abonnement2/new.html.twig', [
            'abonnement2' => $abonnement2,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="abonnement2_show", methods={"GET"})
     */
    public function show(Abonnement2 $abonnement2): Response
    {
        return $this->render('abonnement2/show.html.twig', [
            'abonnement2' => $abonnement2,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="abonnement2_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Abonnement2 $abonnement2): Response
    {
        $form = $this->createForm(Abonnement2Type::class, $abonnement2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('abonnement2_index');
        }

        return $this->render('abonnement2/edit.html.twig', [
            'abonnement2' => $abonnement2,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="abonnement2_delete", methods={"POST"})
     */
    public function delete(Request $request, Abonnement2 $abonnement2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abonnement2->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($abonnement2);
            $entityManager->flush();
        }

        return $this->redirectToRoute('abonnement2_index');
    }
}
