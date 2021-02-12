<?php

namespace App\Controller;

use App\Entity\Legation;
use App\Form\LegationType;
use App\Repository\LegationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/legation")
 */
class LegationController extends AbstractController
{

    /**
     * @Route("/new", name="legation_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $legation = new Legation();
        $form = $this->createForm(LegationType::class, $legation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($legation);
            $entityManager->flush();
            $this->addFlash('success', 'تم إضافة مندوبية  بنجاح');
            return $this->redirectToRoute('legation_show');
        }

        return $this->render('legation/new.html.twig', [
            'legation' => $legation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show", name="legation_show")
     * @param LegationRepository $legationRepository
     * @return Response
     */
    public function show(LegationRepository $legationRepository): Response
    {
        $legation = $legationRepository->findOneBy(['id' => 1]);
        return $this->render('legation/show.html.twig', [
            'legation' => $legation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="legation_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Legation $legation
     * @return Response
     */
    public function edit(Request $request, Legation $legation): Response
    {
        $form = $this->createForm(LegationType::class, $legation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'تم تعديل مندوبية  بنجاح');
            return $this->redirectToRoute('legation_show');
        }

        return $this->render('legation/edit.html.twig', [
            'legation' => $legation,
            'form' => $form->createView(),
        ]);
    }

}
