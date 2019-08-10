<?php

namespace App\Entity\Tiers;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Tiers\Client;
use App\Entity\Tiers\Site;

/**
 * @ORM\Table(name="tiers_contact")
 * @ORM\Entity(repositoryClass="App\Repository\Tiers\ContactRepository")
 */
class Contact
{
    public function __toString() {
        return $this->firstname . ' ' . strtoupper($this->lastname);
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fonction;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tiers\Client")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @var Site
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tiers\Site")
     * @ORM\JoinColumn(nullable=true)
     */
    private $site;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): self
    {
        $this->fonction = $fonction;

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

    public function getSite(): ?Site
    {
        return $this->site;
    }
    
    public function setSite(?Site $site): void
    {
        $this->site = $site;
    }
}
