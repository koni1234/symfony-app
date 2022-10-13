<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Input\LoginInput;
use App\DTO\Output\LoginOutput;
use App\Manager\LoginManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer, private ValidatorInterface $validator, private LoginManager $loginManager)
    {
    }

    #[Route('/api/login', name: 'login', methods: 'POST')]
    #[OA\Post(requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: new Model(type: LoginInput::class))))]
    #[OA\Response(
        response: 200,
        description: 'Return the jwt token',
        content: new Model(type: LoginOutput::class)
    )]
    public function login(Request $request): Response
    {
        /** @var LoginInput $dto */
        $dto = $this->serializer->deserialize($request->getContent(), LoginInput::class, 'json');
        $errors = $this->validator->validate($dto);

        if ($errors->count() > 0) {
            throw new ValidationFailedException(LoginInput::class, $errors);
        }

        return $this->json($this->loginManager->login($dto));
    }
}
