<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Entity\Teacher;
use App\Form\MissionType;
use App\Form\SearchFormType;
use App\Repository\MissionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mission")
 */
class MissionController extends AbstractController
{
    /**
     * @Route("/", name="mission_index", methods={"GET","POST"})
     * @param MissionRepository $missionRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(MissionRepository $missionRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->get('search')->getData() ?? '';
            $results = $missionRepository->findMissionByCriteria($criteria);
        } else {
            $results = $missionRepository->findby([], ['id' => 'DESC']);
        }

        if ($request->query->get('filter') == 'شغور') {
            $results = $missionRepository->findby(['type' => true], ['id' => 'DESC']);
        } elseif ($request->query->get('filter') == 'ظرفية') {
            $results = $missionRepository->findby(['type' => false], ['id' => 'DESC']);
        }


        $missions = $paginator->paginate($results, $request->query->getInt('page', 1), 20);
        return $this->render('mission/index.html.twig', [
            'missions' => $missions,
            'form' => $form->createView(),
            'option' => $request->query->get('filter')]);


    }

    /**
     * @Route("/{id}/new", name="mission_new", methods={"GET","POST"})
     * @param Request $request
     * @param Teacher $teacher
     * @return Response
     */
    public
    function new(Request $request, Teacher $teacher): Response
    {

        $mission = new Mission();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $mission->setTeacher($teacher);
            $entityManager->persist($mission);
            $entityManager->flush();
            $this->addFlash('success', 'تم إضافة نيابة بنجاح');
            return $this->redirectToRoute('teacher_show', ['id' => $teacher->getId()]);
        }
        return $this->render('mission/new.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mission_show", methods={"GET"})
     * @param Mission $mission
     * @return Response
     */
    public function show(Mission $mission): Response
    {
        return $this->render('mission/show.html.twig', [
            'mission' => $mission,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mission_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Mission $mission
     * @return Response
     */
    public function edit(Request $request, Mission $mission): Response
    {
        /** @var Teacher $teacher */
        $teacher = $mission->getTeacher();
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'تم تعديل نيابة بنجاح');
            return $this->redirectToRoute('teacher_show', ['id' => $teacher->getId()]);
        }

        return $this->render('mission/edit.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mission_delete", methods={"DELETE"})
     * @param Request $request
     * @param Mission $mission
     * @return Response
     */
    public function delete(Request $request, Mission $mission): Response
    {
        /** @var Teacher $teacher */
        $teacher = $mission->getTeacher();
        if ($this->isCsrfTokenValid('option' . $mission->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mission);
            $entityManager->flush();
            $this->addFlash('success', 'تم حذف نيابة بنجاح');
        }

        return $this->redirectToRoute('teacher_show', ['id' => $teacher->getId()]);
    }

    /**
     * @Route ("/print/{value}", name="mission_print", methods={"GET"}, priority=2)
     * @param Request $request
     * @param MissionRepository $missionRepository
     * @param $value
     * @return Response
     */
    public function  print(Request $request, MissionRepository $missionRepository, $value): Response
    {
        if ($value === 'الظرفية') {
            $missions = $missionRepository->findBy(['type' => '0'], ['id' => 'DESC']);
        } elseif ($value === 'الشغور') {
            $missions = $missionRepository->findBy(['type' => '1'], ['id' => 'DESC']);
        } else {
            $missions = $missionRepository->findAll();
        }
        return $this->render('mission/print.html.twig', [
            'missions' => $missions,
            'value' => $value
        ]);
    }
}
