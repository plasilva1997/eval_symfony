<?php

namespace App\Controller;

use App\Entity\Film;
use App\Repository\CategorieRepository;
use App\Repository\FilmRepository;
use App\Service\JsonCircularSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FilmController extends AbstractController
{

    /**
     * @Route("/filmshow/{id}", name="film_show")
     * @param CategorieRepository $categorieRepository
     * @param FilmRepository $filmRepository
     * @param int $id
     * @return Response
     */
    public function showActeurAction(CategorieRepository $categorieRepository, FilmRepository $filmRepository, $id = 0): Response
    {

        $film = new Film();
        $film = $filmRepository->findAll();
        $categorie = $categorieRepository->findAll();
        return $this->render('film/index.html.twig', [
            'categorie' => $categorie,
            'film' => $film,
        ]);
    }

    private $jsonCircularSerializer;
    private $manager;

    public function __construct(JsonCircularSerializer $jsonCircularSerializer, EntityManagerInterface $manager)
    {
        $this->jsonCircularSerializer = $jsonCircularSerializer;
        $this->manager = $manager;

    }


    /**
     * @Route("/films", name="films", methods={"GET"})
     * @param FilmRepository $filmRepository
     * @return Response
     */
    public function filmAction(FilmRepository $filmRepository): Response
    {
        //recuperation donnes BDD
        $film = $filmRepository->findAll();

        //Seriallization
        $jsonContent = $this->jsonCircularSerializer->serialize($film);

        //Création de la JsonResponse
        return JsonResponse::fromJsonString($jsonContent);

    }

    /**
     * @Route("/add/film", name="add_film", methods={"POST"})
     * @param Request $request
     * @param CategorieRepository $categorieRepository
     * @return Response
     */

    public function addFilmAction(Request $request, CategorieRepository $categorieRepository): Response
    {
        $nom = $request->request->get("nom");
        $categorieId = $request->request->get("categorie_id");

        $reponse = new Response();
        if ($categorieId && $nom) {
            $categorie = $categorieRepository->find($categorieId);

            if ($categorie) {
                $film = new Film();
                $film->setNom($nom)
                    ->setCategorieId($categorie);


                $this->manager->persist($film);
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
     * @Route("/sup/film/{id}", name="sup_film", methods={"DELETE"})
     * @param int $id
     * @param filmRepository $filmRepository
     * @return Response
     */

    public function deletFilmAction(FilmRepository $filmRepository, $id = 0): Response
    {
        $film = $filmRepository->find($id);
        $reponse = new Response();

        if ($film){
            $this->manager->remove($film);
            $this->manager->flush();
            $reponse->setStatusCode(200);
        }else{
            $reponse->setStatusCode(400);

        }
        return $reponse;
    }
}
