<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class PartenaireController extends AbstractController
{
    /**
     * @Route("/show/{id}", name="show_phone", methods={"GET"})
     */
    public function show(Partenaire $partenaire, PartenaireRepository $partenaireRepository, SerializerInterface $serializer)
    {
        $partenaire = $partenaireRepository->find($partenaire->getId());
        $data = $serializer->serialize($partenaire, 'json', [
            'groups' => ['show']
        ]);
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/addP", name="add", methods={"POST"})
     */
    public function new(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $partenaire = $serializer->deserialize($request->getContent(), Partenaire::class, 'json');
        $entityManager->persist($partenaire);
        $entityManager->flush();
        $data = [
            'status' => 201,
            'message' => 'Le téléphone a bien été ajouté'
        ];
        return new JsonResponse($data, 201);
    }
/**
     * @Route("/bloquer/{id}", name="update_par", methods={"PUT"})
     */
    public function update(Request $request, SerializerInterface $serializer, Partenaire $partenaire, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $partenaireUpdate = $entityManager->getRepository(Partenaire::class)->find($partenaire->getId());
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value){
            if($key && !empty($value)) {
                $name = ucfirst($key);
                $setter = 'set'.$name;
                $partenaireUpdate->$setter($value);
            }
        }
        $errors = $validator->validate($partenaireUpdate);
        if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();
        $data = [
            'status' => 200,
            'message' => 'Le partenaire a bien été mis à jour'
        ];
        return new JsonResponse($data);
    }

}

