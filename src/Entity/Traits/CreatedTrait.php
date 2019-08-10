<?php

namespace App\Entity\Traits;

trait CreatedTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @ORM\PrePersist
     * @throws \Exception
     */
    public function onPrePersist()
    {
        if (is_null($this->created)) {
            $this->created = new \DateTime();
        }
    }

    /**
     * Set created
     *
     * @param null $date
     * @return $this
     * @throws \Exception
     */
    public function setCreated($date = null)
    {
        if (!is_null($date)) {
            $this->created = $date;
        }

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}
