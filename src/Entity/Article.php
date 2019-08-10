<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;
use App\Entity\Traits\CreatedTrait;
use App\Entity\Traits\UpdatedTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    public function __construct() {
        $this->created = new \Datetime();
    }

    public function __toString() {
        return $this->title;
    }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @Serializer\Accessor(getter="getCreatedTimestamp")
     * @Serializer\SerializedName("created")
     * @Expose
     */
    private $createdTimestamp;

    /**
     * @var string
     *
     * @Serializer\Accessor(getter="getUpdatedTimestamp")
     * @Serializer\SerializedName("updated")
     * @Expose
     */
    private $updatedTimestamp;

    use CreatedTrait;
    use UpdatedTrait;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"persist"}))
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="boolean")
     */
    private $public;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get createdTimestamp
     *
     * @Serializer\VirtualProperty()
     * @return string
     */
    public function getCreatedTimestamp()
    {
        return $this->getCreated()->getTimestamp();
    }

    /**
     * Get updatedTimestamp
     *
     * @Serializer\VirtualProperty()
     * @return string
     */
    public function getUpdatedTimestamp()
    {
        return $this->getUpdated()->getTimestamp();
    }

    public function getAuthor(): User
    {
        return $this->author;
    }
    
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;
        return $this;
    }
}