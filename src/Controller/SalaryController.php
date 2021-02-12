<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Entity\Salary;
use App\Entity\Teacher;
use App\Form\SalaryType;
use App\Repository\SalaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salary")
 */
class SalaryController extends AbstractController
{

    /**
     * @Route("/", name="salary_index", methods={"GET","POST"})
     * @param SalaryRepository $salaryRepository
     * @return Response
     */
    public function index(SalaryRepository $salaryRepository): Response
    {
        return $this->render('salary/index.html.twig', [
            'salaries' => $salaryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="salary_new", methods={"GET","POST"})
     * @param Request $request
     * @param Mission $mission
     * @return Response
     */
    public
    function new(Request $request, Mission $mission): Response
    {
        /** @var Teacher $teacher */
        $teacher = $mission->getTeacher();
        $salary = new Salary();
        $form = $this->createForm(SalaryType::class, $salary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $salary->setMission($mission);
            $entityManager->persist($salary);
            $entityManager->flush();

            return $this->redirectToRoute('teacher_show', ['id' => $teacher->getId()]);
        }

        return $this->render('salary/new.html.twig', [
            'salary' => $salary,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="salary_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Salary $salary
     * @return Response
     */
    public function edit(Request $request, Salary $salary): Response
    {
        /** @var Mission $mission */
        $mission = $salary->getMission();
        /** @var Teacher $teacher */
        $teacher = $mission->getTeacher();
        $form = $this->createForm(SalaryType::class, $salary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('teacher_show', ['id' => $teacher->getId()]);
        }

        return $this->render('salary/edit.html.twig', [
            'salary' => $salary,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="salary_delete", methods={"DELETE"})
     * @param Request $request
     * @param Salary $salary
     * @return Response
     */
    public function delete(Request $request, Salary $salary): Response
    {
        /** @var Mission $mission */
        $mission = $salary->getMission();
        /** @var Teacher $teacher */
        $teacher = $mission->getTeacher();
        if ($this->isCsrfTokenValid('option' . $salary->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($salary);
            $entityManager->flush();
        }

        return $this->redirectToRoute('teacher_show', ['id' => $teacher->getId()]);
    }
}
