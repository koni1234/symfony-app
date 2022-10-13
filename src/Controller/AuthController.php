<?php
declare(strict_types=1);

namespace App\Controller;

use App\DTO\Input\Login;
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
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    #[Route('/api/login', name: 'login', methods: 'POST')]
    #[OA\Post(requestBody: new OA\RequestBody(content: new OA\JsonContent(ref: new Model(type: Login::class))))]
    #[OA\Response(
        response: 200,
        description: 'Successful user logged response',
        content: new Model(type: Login::class)
    )]
    public function login(Request $request): Response
    {
        $dto = $this->serializer->deserialize($request->getContent(), Login::class, 'json');
        $errors = $this->validator->validate($dto);

        if ($errors->count() > 0){
            throw new ValidationFailedException(Login::class, $errors);
        }

        return $this->json($dto);
    }
}
