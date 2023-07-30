<?php

namespace Ever\ScheduledPublication\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected ?\DateTime $dateAdd = null;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected \DateTime $dateUpd;

    /**
     * @return \DateTime
     */
    public function getDateAdd(): ?\DateTime
    {
        return $this->dateAdd;
    }

    /**
     * @param \DateTime $dateAdd
     */
    public function setDateAdd(\DateTime $dateAdd): self
    {
        $this->dateAdd = $dateAdd;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpd(): \DateTime
    {
        return $this->dateUpd;
    }

    /**
     * @param \DateTime $dateUpd
     */
    public function setDateUpd(\DateTime $dateUpd): self
    {
        $this->dateUpd = $dateUpd;
        return $this;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setDateUpd(new \DateTime());

        if ($this->getDateAdd() === null) {
            $this->setDateAdd(new \DateTime());
        }
    }
}
