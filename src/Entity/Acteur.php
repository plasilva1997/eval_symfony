<?php

namespace App\Entity;

use App\Repository\ActeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActeurRepository::class)
 */
class Acteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Film::class, inversedBy="acteurs")
     */
    private $film_id;

    public function __construct()
    {
        $this->film_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|film[]
     */
    public function getFilmId(): Collection
    {
        return $this->film_id;
    }

    public function addFilmId(film $filmId): self
    {
        if (!$this->film_id->contains($filmId)) {
            $this->film_id[] = $filmId;
        }

        return $this;
    }

    public function removeFilmId(film $filmId): self
    {
        $this->film_id->removeElement($filmId);

        return $this;
    }
}
