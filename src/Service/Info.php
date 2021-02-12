<?php


namespace App\Service;

use App\Entity\Legation;
use App\Entity\Subscription;
use App\Repository\LegationRepository;
use App\Repository\SubscriptionRepository;
use DateTimeInterface;

class Info
{
    /**
     * @var SubscriptionRepository
     */
    private SubscriptionRepository $subscriptionRepository;
    /**
     * @var LegationRepository
     */
    private LegationRepository $legation;

    public function __construct(SubscriptionRepository $subscriptionRepository, LegationRepository $legationRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->legation = $legationRepository;
    }


    public function getLegation(): string
    {
        /** @var string $legation */
        $legation = $this->legation->findOneBy(['id' => 1]);
        return $legation;
    }

    public function getRegion(): string
    {
        /** @var Legation $legation */
        $legation = $this->legation->findOneBy(['id' => 1]);
        /** @var string $region */
        $region = $legation->getRegion();
        return $region;
    }

    public function getOffer(): string
    {
        /** @var Subscription $last */
        $last = $this->subscriptionRepository->findOneBy([], ['id' => 'DESC']);
        /** @var string $offer */
        $offer = $last->getOffer();
        return $offer;
    }

    public function getSubscription(): DateTimeInterface
    {
        /** @var Subscription $last */
        $last = $this->subscriptionRepository->findOneBy([], ['id' => 'DESC']);
        /** @var DateTimeInterface $endAt */
        $endAt = $last->getEndAt();
        return $endAt;
    }

}
