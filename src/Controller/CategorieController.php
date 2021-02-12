<?php

namespace App\Controller;


use App\Repository\CategorieRepository;
use App\Service\JsonCircularSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class CategorieController extends AbstractController
{
    private $jsonCircularSerializer;
    private $manager;

    public function __construct(JsonCircularSerializer $jsonCircularSerializer, EntityManagerInterface $manager)
    {
        $this->jsonCircularSerializer = $jsonCircularSerializer;
        $this->manager = $manager;
    }


    /**
     * @Route("/categorie", name="categorie", methods={"GET"})
     * @param CategorieRepository $categorieRepository
     * @return Response
     */
    public function categorieAction(CategorieRepository $categorieRepository): JsonResponse
    {
        //recuperation donnes BDD
        $categorie = $categorieRepository->findAll();

        //Seriallization
        $jsonContent = $this->jsonCircularSerializer->serialize($categorie);

        //Création de la JsonResponse
        return JsonResponse::fromJsonString($jsonContent);
    }

    /**
     * @Route("/add/categorie", name="add_categorie", methods={"POST"})
     * @param Request $request
     * @return Response
     */


    public function addCategorieAction(Request $request): Response
    {

        $nom = $request->request->get("nom");


        $reponse = new Response();
        if ($nom) {

            $categorie = new Categorie();
            $categorie->setNom($nom);


            $this->manager->persist($categorie);
            $this->manager->flush();
            $reponse->setStatusCode(201);
        } else {
            $reponse->setStatusCode(400);
        }

        return $reponse;


    }

    /**
     * @Route("/sup/categorie/{id}", name="sup_categorie", methods={"DELETE"})
     * @return Response
     */

    public function deletecoleAction($id = 0, CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->find($id);
        $reponse = new Response();

        if ($categorie){
            $this->manager->remove($categorie);
            $this->manager->flush();
            $reponse->setStatusCode(200);
        }else{
            $reponse->setStatusCode(400);

        }
        return $reponse;
    }

}
