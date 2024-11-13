<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWSProvider\JWSProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ApiLoginController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $userPasswordHasher;
    private JWSProviderInterface $jwtProvider;

    public function __construct(
        JWSProviderInterface        $jwtProvider,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface      $entityManager,
    )
    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->jwtProvider = $jwtProvider;
    }

    #[Route('/api/login', name: 'api_auth_login', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return $this->json([
                'message' => 'Missing credentials',
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if (!$user || !$this->userPasswordHasher->isPasswordValid($user, $password)) {
            return $this->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_BAD_REQUEST);
        }

//        $userData = [
//            'id' => $user->getId(),
//            'email' => $user->getEmail(),
//        ];
//
//        $token = $this->jwtProvider->create($userData);
        $token = $this->jwtProvider->create((array)$user);

        return $this->json([
            'id' => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}
