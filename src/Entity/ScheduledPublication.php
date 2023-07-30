<?php


namespace Ever\ScheduledPublication\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ever\ScheduledPublication\Traits\Timestampable;

/**
 * @ORM\Table()
 *  @ORM\Entity(repositoryClass="Ever\ScheduledPublication\Repository\ScheduledPublicationRepository")
 *  @ORM\HasLifecycleCallbacks
 */
class ScheduledPublication
{

    use Timestampable;

    const STATUS_WAITING = 1;

    const STATUS_DONE = 2;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id_scheduledpublication", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * Type d'objet à publier (Product, Category, CMS)
     * @var string
     *
     * @ORM\Column(name="object", type="string")
     */
    private string $object;

    /**
     * @var int
     *
     * @ORM\Column(name="id_object", type="integer")
     */
    private int $idObject;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="datetime");
     */
    private \DateTime $dueDate;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private int $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getObject(): string
    {
        return $this->object;
    }

    /**
     * @param string $object
     */
    public function setObject(string $object): ScheduledPublication
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdObject(): int
    {
        return $this->idObject;
    }

    /**
     * @param int $idObject
     */
    public function setIdObject(int $idObject): ScheduledPublication
    {
        $this->idObject = $idObject;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDueDate(): \DateTime
    {
        return $this->dueDate;
    }

    /**
     * @param \DateTime $dueDate
     */
    public function setDueDate(\DateTime $dueDate): ScheduledPublication
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): ScheduledPublication
    {
        $this->status = $status;
        return $this;
    }
}
