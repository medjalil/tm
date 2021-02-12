<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findUserNotAdmin();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);

    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setPassword($encoder->encodePassword($user, 'diptunisie123'));
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'تم إضافة  مستخدم  بنجاح');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'تم تعديل  مستخدم  بنجاح');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/option", name="user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('option' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'تم حذف  مستخدم  بنجاح');
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/{id}/enable", name="user_enable")
     * @param User $user
     * @return Response
     */
    public function enable(User $user): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $user->setEnabled(true);
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success', 'لقد تم تفعيل الحساب');
        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/{id}/disable", name="user_disable")
     * @param User $user
     * @return Response
     */
    public function disable(User $user): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $user->setEnabled(false);
        $entityManager->persist($user);
        $entityManager->flush();
        $this->addFlash('success', 'لقد تم تعطيل الحساب');
        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/{id}/change-password", methods={"GET", "POST"}, name="user_change_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param User $user
     * @return Response
     */
    public function changeUserPassword(Request $request, UserPasswordEncoderInterface $encoder, User $user): Response
    {
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $form->get('plainPassword')->getData()));
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'تم تغيير كلمة المرور بنجاح');
            return $this->redirectToRoute('user_index');
        }
        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
