<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/api")
 */
class ListeController extends AbstractController
{
    /**
     * @Route("/liste", name="list",methods={"GET"})
     */
    

    public function index(UserRepository $userRepository, SerializerInterface $serializer)
    {
        $users = $userRepository->findAll();
        $data = $serializer->serialize($users, 'json',['groups' => ['lister']]);

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

}
