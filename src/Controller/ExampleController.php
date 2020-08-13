<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ExampleController extends AbstractController
{
    /**
     * @Route("/example", name="example")
     */
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->getPosts();

        $data = [];

        foreach ($posts as $post) {
            /** @var User $user */
            $user = $post->getUser();

            $userPosts = [];
            foreach ($user->getPosts() as $userPost) {
                $userPosts[] = [
                    'id' => $userPost->getId(),
                    'title' => $userPost->getTitle(),
                    'type' => $userPost->getType(),
                ];
            }

            $data[] = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'type' => $post->getType(),
                'user' => [
                    'id' => $user->getId(),
                    'posts' => $userPosts
                ]
            ];
        }


        return $this->json($data);
    }
}
