<?php

namespace App\Entity\Tiers;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Tiers\Client;

/**
 * @ORM\Table(name="tiers_site")
 * @ORM\Entity(repositoryClass="App\Repository\Tiers\SiteRepository")
 */
class Site
{
    public function __toString() {
        return $this->societe;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_cweb;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $societe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $naf;

        /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $horaire;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tiers\Client", inversedBy="sites")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCweb(): ?int
    {
        return $this->id_cweb;
    }
    
    public function setIdCweb(int $id_cweb): self
    {
        $this->id_cweb = $id_cweb;
        return $this;
    }

    public function getSociete(): ?string
    {
        return $this->societe;
    }

    public function setSociete(string $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getNaf(): ?string
    {
        return $this->naf;
    }

    public function setNaf(string $naf): self
    {
        $this->naf = $naf;

        return $this;
    }

    public function getHoraire(): ?string
    {
        return $this->horaire;
    }

    public function setHoraire(string $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
    
    public function setClient(?Client $client): void
    {
        $this->client = $client;
    }
}
