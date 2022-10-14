<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Input\LoginInput;
use App\DTO\Output\LoginOutput;
use App\Entity\User;
use App\Manager\LoginManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AuthController extends AbstractController
{
    public function __construct(private LoginManager $loginManager)
    {
    }

    #[Route('/api/login', name: 'api_login', methods: 'POST')]
    #[OA\Post(requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: new Model(type: LoginInput::class))))]
    #[OA\Response(
        response: 200,
        description: 'Return the jwt token',
        content: new Model(type: LoginOutput::class)
    )]
    
    public function index(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json($this->loginManager->setJWT($user));
    }
}
