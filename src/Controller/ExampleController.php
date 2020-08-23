<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ExampleController extends AbstractController
{
    /**
     * @Route("/first", name="first")
     */
    public function first(PostRepository $postRepository, SerializerInterface $serializer)
    {
        $data =   $serializer->serialize($postRepository->getPostsByGetResult(), 'json', [
            'circular_reference_limit' => 2,
            'circular_reference_handler' => static function ($object) {
                return $object->getId();
            }
        ]);

        return new Response($data, Response::HTTP_OK, ['Content-type' => 'application/json']);
    }

    /**
     * @Route("/second", name="second")
     */
    public function second(PostRepository $postRepository)
    {
        return $this->json($postRepository->getPostsByGetArrayResult());
    }
}
