<?php

namespace App\Controller;

use App\Entity\Archive;
use App\Entity\Teacher;
use App\Form\ArchiveType;
use App\Form\SearchFormType;
use App\Repository\ArchiveRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/archive")
 */
class ArchiveController extends AbstractController
{
    /**
     * @Route("/", name="archive_index", methods={"GET","POST"})
     * @param ArchiveRepository $archiveRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(ArchiveRepository $archiveRepository, Request $request, PaginatorInterface $paginator): Response
    {

        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->get('search')->getData() ?? '';
            $results = $archiveRepository->findTeacherByArchive($criteria);
        } else {
            $results = $archiveRepository->findby([], ['id' => 'DESC']);
        }

        $archives = $paginator->paginate($results, $request->query->getInt('page', 1), 10);
        return $this->render('archive/index.html.twig', [
            'archives' => $archives,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="archive_new", methods={"GET","POST"})
     * @param Request $request
     * @param Teacher $teacher
     * @return Response
     */
    public function new(Request $request, Teacher $teacher): Response
    {
        $archive = new Archive();
        $form = $this->createForm(ArchiveType::class, $archive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $archive->setTeacher($teacher);
            $teacher->setArchived(true);
            $entityManager->persist($archive);
            $entityManager->flush();

            $this->addFlash('success', ' تم نقل المعلم إلى الأرشيف');
            return $this->redirectToRoute('archive_index');
        }

        return $this->render('archive/new.html.twig', [
            'archive' => $archive,
            'form' => $form->createView(),

        ]);
    }


    /**
     * @Route("/{id}", name="archive_delete", methods={"DELETE"})
     * @param Request $request
     * @param Archive $archive
     * @return Response
     */
    public function delete(Request $request, Archive $archive): Response
    {
        if ($this->isCsrfTokenValid('option' . $archive->getId(), $request->request->get('_token'))) {
            /** @var Teacher $teacher */
            $teacher = $archive->getTeacher();
            $teacher->setArchived(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($archive);
            $entityManager->flush();
            $this->addFlash('success', ' تم نقل المعلم إلى القائمة ');
        }

        return $this->redirectToRoute('teacher_index');
    }
}
