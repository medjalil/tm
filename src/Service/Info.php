<?php


namespace App\Service;

use App\Entity\Subscription;
use App\Repository\LegationRepository;
use App\Repository\SubscriptionRepository;

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

    public function getOffer(): string
    {
        /** @var Subscription $last */
        $last = $this->subscriptionRepository->findOneBy([], ['id' => 'DESC']);
        /** @var string $offer */
        $offer = $last->getOffer();
        return $offer;
    }
}
