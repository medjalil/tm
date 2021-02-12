<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\SearchFormType;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teacher")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route("/", name="teacher_index", methods={"GET","POST"})
     * @param TeacherRepository $teacherRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(TeacherRepository $teacherRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->get('search')->getData() ?? '';
            $results = $teacherRepository->findTeacherByCriteria($criteria);
        } else {
            $results = $teacherRepository->findby(['archived' => false], ['id' => 'DESC']);
        }
        $teachers = $paginator->paginate($results, $request->query->getInt('page', 1), 30);
        return $this->render('teacher/index.html.twig', [
            'teachers' => $teachers,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/new", name="teacher_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($teacher);
            $entityManager->flush();
            $this->addFlash('success', 'تمت إضفة المعلم بنجاح');

            return $this->redirectToRoute('teacher_index');
        }

        return $this->render('teacher/new.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="teacher_show",methods={"GET","POST"})
     * @param Teacher $teacher
     * @return Response
     */
    public function show(Teacher $teacher): Response
    {
        return $this->render('teacher/show.html.twig', [
            'teacher' => $teacher,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="teacher_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Teacher $teacher
     * @return Response
     */
    public function edit(Request $request, Teacher $teacher): Response
    {
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'تم تعديل معطيات المعلم بنجاح');
            return $this->redirectToRoute('teacher_show', ['id' => $teacher->getId()]);
        }

        return $this->render('teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="teacher_delete", methods={"DELETE"})
     * @param Request $request
     * @param Teacher $teacher
     * @return Response
     */
    public function delete(Request $request, Teacher $teacher): Response
    {
        if ($this->isCsrfTokenValid('option' . $teacher->getId(), $request->request->get('_token'))) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($teacher);
                $entityManager->flush();
                $this->addFlash('success', 'تم حذف المعلم بنجاح');
            } catch (\Exception $e) {
                $this->addFlash('danger', 'هذا المعلم لا يمكن حدفه لديه نيابات');
            }
        }

        return $this->redirectToRoute('teacher_index');
    }
}
