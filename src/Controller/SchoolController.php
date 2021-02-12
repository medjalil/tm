<?php

namespace App\Controller;

use App\Entity\School;
use App\Form\SchoolType;
use App\Form\SearchFormType;
use App\Repository\SchoolRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/school")
 */
class SchoolController extends AbstractController
{
    /**
     * @Route("/", name="school_index", methods={"GET","POST"})
     * @param SchoolRepository $schoolRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(SchoolRepository $schoolRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->get('search')->getData() ?? '';
            $results = $schoolRepository->findSchoolByName($criteria);
        } else {
            $results = $schoolRepository->findby([], ['id' => 'DESC']);
        }
        $schools = $paginator->paginate($results, $request->query->getInt('page', 1), 10);
        return $this->render('school/index.html.twig', [
            'schools' => $schools,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="school_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $school = new School();
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($school);
            $entityManager->flush();
            $this->addFlash('success', 'تم إضافة مؤسسة  بنجاح');
            return $this->redirectToRoute('school_index');
        }

        return $this->render('school/new.html.twig', [
            'school' => $school,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="school_edit", methods={"GET","POST"})
     * @param Request $request
     * @param School $school
     * @return Response
     */
    public function edit(Request $request, School $school): Response
    {
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'تم تعديل مؤسسة  بنجاح');
            return $this->redirectToRoute('school_index');
        }

        return $this->render('school/edit.html.twig', [
            'school' => $school,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="school_delete", methods={"DELETE"})
     * @param Request $request
     * @param School $school
     * @return Response
     */
    public function delete(Request $request, School $school): Response
    {
        if ($this->isCsrfTokenValid('option' . $school->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($school);
            $entityManager->flush();
            $this->addFlash('success', 'تم حذف مؤسسة  بنجاح');
        }

        return $this->redirectToRoute('school_index');
    }
}
