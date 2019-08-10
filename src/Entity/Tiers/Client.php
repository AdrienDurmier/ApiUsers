<?php

namespace App\Entity\Tiers;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tiers_client")
 * @ORM\Entity(repositoryClass="App\Repository\Tiers\ClientRepository")
 */
class Client
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
     * @ORM\Column(type="integer")
     */
    private $id_cweb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $societe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $naf;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tiers\Site", mappedBy="client", cascade={"remove"})
     */
    private $sites;


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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function addSite(Site $site)
    {
      $this->sites[] = $site;
    }

    public function removeSite(Site $site)
    {
      $this->sites->removeElement($site);
    }

    public function getSites()
    {
      return $this->sites;
    }
}
