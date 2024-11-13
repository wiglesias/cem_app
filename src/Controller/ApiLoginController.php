<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_auth_login', methods: ['POST'])]
    public function index(): JsonResponse
    {
        $user = $this->getUser();
        return $this->json([
            'id' => $user->getUserIdentifier(),
        ]);
    }
}
