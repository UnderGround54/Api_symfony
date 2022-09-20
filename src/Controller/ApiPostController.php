<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiPostController extends AbstractController
{
    #[Route('/api/post', name: 'app_api_post', methods:['GET'])]
    public function index(PostRepository $postRepository): JsonResponse
    {
        return $this->json($postRepository->findAll(), 200, [], ['groups' => 'post']);
    }

    #[Route('/api/post', name: 'api_post_create', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serialize, EntityManagerInterface $manager,
    ValidatorInterface $validator)
    {
        $jsonreceive = $request->getContent();

        try {
            $post = $serialize->deserialize($jsonreceive, Post::class, 'json');

            $errors = $validator->validate($post);

            if (count($errors) > 0){
                return $this->json($errors, 400);
            }

            $manager->persist($post);
            $manager->flush();

            return $this->json($post, 201, [], ['groups' => 'post']);
        } catch (NotEncodableValueException $ex) {
            return $this->json([
                'status' => 400,
                'message' => $ex->getMessage()
            ], 400);
        }
       
    }
}
