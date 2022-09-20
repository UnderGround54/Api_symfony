<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPostController extends AbstractController
{
    #[Route('/api/post', name: 'app_api_post', methods:['GET'])]
    public function index(PostRepository $postRepository, SerializerInterface $serializer): JsonResponse
    {
        $post = $postRepository->findAll();
        $json = $serializer->serialize($post, 'json', ['groups' => 'post']);
        
        $response = new JsonResponse($json, 200, [], true);

        return $response;
    }
}
