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

    /**
     * @var string
     */
    private $nexmoId;

    /**
     * @var string
     */
    private $nexmoSecret;

    public function __construct(EntityManagerInterface $entityManager, string $nexmoId, string $nexmoSecret)
    {
        $this->entityManager = $entityManager;
        $this->nexmoId = $nexmoId;
        $this->nexmoSecret = $nexmoSecret;
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
            $basic  = new \Nexmo\Client\Credentials\Basic($this->nexmoId, $this->nexmoSecret);
            $client = new \Nexmo\Client($basic);

            $client->message()->send([
                'to' => $user->getPhoneNumber(),
                'from' => $from,
                'text' => $message
            ]);
        }
    }
}