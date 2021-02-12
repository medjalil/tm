<?php

namespace App\Controller;


use App\Form\ContactType;
use App\Repository\CityRepository;
use App\Repository\LegationRepository;
use App\Repository\MissionRepository;
use App\Repository\OfferRepository;
use App\Repository\SchoolRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\TeacherRepository;
use App\Repository\UserRepository;
use App\Service\Info;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;


class PageController extends AbstractController
{


    /**
     * @var Info
     */
    private Info $legation;

    public function __construct(Info $legation)
    {
        $this->legation = $legation;
    }

    /**
     * @Route("/", name="dashboard")
     * @param TeacherRepository $teacherRepository
     * @param MissionRepository $missionRepository
     * @param SchoolRepository $schoolRepository
     * @param CityRepository $cityRepository
     * @param LegationRepository $legationRepository
     * @param UserRepository $userRepository
     * @param SubscriptionRepository $subscriptionRepository
     * @param OfferRepository $offerRepository
     * @return Response
     */
    public function dashboard(TeacherRepository $teacherRepository, MissionRepository $missionRepository, SchoolRepository $schoolRepository, CityRepository $cityRepository, LegationRepository $legationRepository, UserRepository $userRepository, SubscriptionRepository $subscriptionRepository, OfferRepository $offerRepository
    ): Response
    {
        $cities = count($cityRepository->findAll());
        $schools = count($schoolRepository->findAll());
        $teachers = count($teacherRepository->findBy(['archived' => false]));
        $mission0 = count($missionRepository->countMissionsByType(false));
        $mission1 = count($missionRepository->countMissionsByType(true));
        $missions = $mission0 + $mission1;
//        $users = count($userRepository->findByRole('ROLE_USER'));
//        $subscriptions = count($subscriptionRepository->findAll());
//        $offers = count($offerRepository->findAll());

        return $this->render('page/dashboard.html.twig', [
            'stats' => compact('cities', 'schools', 'teachers', 'missions', 'mission0', 'mission1'),
//            'users' => $users,
//            'subscriptions' => $subscriptions,
//            'offers' => $offers,
        ]);
    }


    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new TemplatedEmail())
                ->from(new Address('noreply.diptunisie@gmail.com', 'برنامج إدارة المعلمين النواب'))
                ->to('societedip@gmail.com')
                ->subject('رسالة من برنامج المعلمين النواب')
                ->htmlTemplate('page/email.html.twig')
                ->context([
                    'legation' => $this->legation,
                    'user' => $this->getUser(),
                    'subject' => $form->get('subject')->getData(),
                    'message' => $form->get('message')->getData(),
                ]);

            $mailer->send($email);
            $this->addFlash('success', 'تم إرسال رسالتكم بنجاح. سنقوم بالرد عليها في أقرب وقت. شكرا');
            return $this->redirectToRoute('contact');
        }

        return $this->render('page/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
