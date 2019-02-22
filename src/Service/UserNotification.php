<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserNotification
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $from
     * @param string $message
     *
     * @throws \Nexmo\Client\Exception\Exception
     * @throws \Nexmo\Client\Exception\Request
     * @throws \Nexmo\Client\Exception\Server
     */
    public function notifyBySms(string $from, string $message)
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            $basic  = new \Nexmo\Client\Credentials\Basic('01b83185', 'CKhZzEgqY6wxLPXM');
            $client = new \Nexmo\Client($basic);

            $client->message()->send([
                'to' => $user->getPhoneNumber(),
                'from' => $from,
                'text' => $message
            ]);
        }
    }
}