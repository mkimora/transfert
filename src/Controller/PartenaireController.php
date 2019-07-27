<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Partenaire;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * @Route("/api")
 */
class PartenaireController extends AbstractController
{
    /**
     * @Route("/show", name="show", methods={"GET"})
     */
    public function show(Partenaire $partenaire, PartenaireRepository $partenaireRepository, SerializerInterface $serializer)
    {
       
        $partenaire = $partenaireRepository->findAll();
        $data = $serializer->serialize($partenaire, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/addP", name="add", methods={"POST"})
     */
    public function register(Request $request,  EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $values = json_decode($request->getContent());
    
        if(isset($values->nompartenaire,$values->numcompte)) {
            $partenaire = new Partenaire();
            $partenaire->setNompartenaire($values->nompartenaire);
            $partenaire->setRaisonSocial($values->raisonSocial);
            $partenaire->setNinea($values->ninea);
            $partenaire->setNumcompte($values->numcompte);
            $partenaire->setSolde($values->solde);
            $partenaire->setEtat($values->etat);

            $partenaire->setAdresse($values->adresse);
            var_dump($values);

            $repo=$this->getDoctrine()->getRepository(User::class);
            $user=$repo-> find($values->createdby);
            $partenaire->setCreatedby($user);
              $errors = $validator->validate($partenaire);
            if(count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Type' => 'application/json'
                ]);
            }
            $entityManager->persist($partenaire);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' => 'Le partenaire a été créé'
            ];

            return new JsonResponse($data, 201);
        }
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner les tous  champs'
        ];
        return new JsonResponse($data, 500);
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
            'message' => 'Le partenaire a bien été bolquer'
        ];
        return new JsonResponse($data);
    }

}

