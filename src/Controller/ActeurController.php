<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Repository\ActeurRepository;
use App\Repository\FilmRepository;
use App\Service\JsonCircularSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActeurController extends AbstractController
{
    private $jsonCircularSerializer;
    private $manager;

    public function __construct(JsonCircularSerializer $jsonCircularSerializer, EntityManagerInterface $manager)
    {
        $this->jsonCircularSerializer = $jsonCircularSerializer;
        $this->manager = $manager;
    }

    /**
     * @Route("/acteur", name="acteur", methods={"GET"})
     * @param ActeurRepository $acteurRepository
     * @return Response
     */
    public function acteurAction(ActeurRepository $acteurRepository): Response
    {
        //recuperation donnes BDD
        $acteur = $acteurRepository->findAll();

        //Seriallization
        $jsonContent = $this->jsonCircularSerializer->serialize($acteur);

        //Création de la JsonResponse
        return JsonResponse::fromJsonString($jsonContent);

    }


    /**
     * @Route("/add/acteur", name="add_acteur", methods={"POST"})
     * @param Request $request
     * @param FilmRepository $filmRepository
     * @return Response
     */

    public function addActeurAction(Request $request, FilmRepository $filmRepository): Response
    {
        $nom = $request->request->get("nom");
        $filmId = $request->request->get("film_id");

        $reponse = new Response();

        if ($filmId && $nom) {
            $film = $filmRepository->find($filmId);

            if ($film) {
                $acteur = new Acteur();
                $acteur->setNom($nom)
                    ->addFilmId($film);


                $this->manager->persist($acteur);
                $this->manager->flush();
                $reponse->setStatusCode(201);
            } else {
                $reponse->setStatusCode(400);
            }
        } else {
            $reponse->setStatusCode(400);
        }

        return $reponse;

    }

    /**
     * @Route("/sup/acteur/{id}", name="sup_acteur", methods={"DELETE"})
     * @param int $id
     * @param ActeurRepository $acteurRepository
     * @return Response
     */

    public function deletecoleAction(ActeurRepository $acteurRepository, $id = 0): Response
    {
        $acteur = $acteurRepository->find($id);
        $reponse = new Response();

        if ($acteur){
            $this->manager->remove($acteur);
            $this->manager->flush();
            $reponse->setStatusCode(200);
        }else{
            $reponse->setStatusCode(400);

        }
        return $reponse;
    }
}
