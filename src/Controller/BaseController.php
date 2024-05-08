<?php

namespace App\Controller;

use App\Entity\Notifications;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    protected $notifications;
    public function getAllNotifications(ManagerRegistry $doctrine)
    {
        $notificationsRepo = $doctrine->getRepository(Notifications::class);
        $query = $notificationsRepo->createQueryBuilder('n')
            ->select('n')
            ->innerJoin('n.contrat','c')
            ->where('c.client = :client')
            ->setParameter('client',$this->getUser());
        $this->notifications = $query->getQuery()->getResult();
        return $this->notifications;
    }
}