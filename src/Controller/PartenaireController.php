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
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Operation;

/**
 * @Route("/api")
 */
class PartenaireController extends AbstractController  
{
    /**
     *  @Route("/partenaire", name="liste", methods={"GET"})
     */
    public function show(PartenaireRepository $partenaireRepository, SerializerInterface $serializer)
    {
             $partenaire=$partenaireRepository->findAll();
           
           $data      = $serializer->serialize($partenaire,'json',['groups' => ['lister']]);
            return new Response($data,200,[]);
       
    
    }

    /**
     * @Route("/addP", name="add", methods={"POST"})
     * isGranted("ROLE_SUPER")
     * isGranted("ROLE_ADMIN")
     */
    public function ajoutP(Request $request,  EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator)
    {  $user = $this->getUser();
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

            $repo=$this->getDoctrine()->getRepository(User::class);
            $user=$repo-> find($user->getId());
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
                'message' => 'Le partenaire a été créé par '.$user->getNom().' '.$user->getPrenom()
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
     * @Route("/bloquer/{id}", name="par", methods={"PUT"})
     * isGranted("ROLE_SUPER")
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
            'message' => 'Le partenaire a bien été modifié'
        ];
        return new JsonResponse($data);
    }
    /**
     * @Route("/depot", name="upda", methods={"POST"})
     *
     */
    public function depot(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {   
        $user = $this->getUser();
        
        $values = json_decode($request->getContent());
        $repo = $this->getDoctrine()->getRepository(Partenaire::class);
        $part = $repo-> findOneBy(['numcompte' => $values->numcompte]);
        $solde= $part->getSolde();
        $part->setSolde($values->solde+$solde);
      
        if(isset($part)) {
            $operation = new Operation();
            $operation->setMontantdeposer($values->solde);
            $operation->setSoldeAvantDepot($solde);
            $operation->setDateDepot(new \DateTime('now'));
          
          
            $repo=$this->getDoctrine()->getRepository(Partenaire::class);
            $partenaire=$repo->find($part);
            $operation->setPartenaire($partenaire);
            $entityManager->persist($operation);
            $entityManager->flush();

              $errors = $validator->validate($partenaire);

        $errors = $validator->validate($part);
         if(count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();
        $data = [
            'status' => 200,
             'message' => 'Le depot a éte fait avec succes '.'par '.$user->getNom().' '.$user->getPrenom()];
        return new JsonResponse($data);
    }

}
}
