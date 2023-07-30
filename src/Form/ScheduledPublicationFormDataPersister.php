<?php

    namespace Ever\ScheduledPublication\Form;

use Ever\ScheduledPublication\Entity\ScheduledPublication;
use Ever\ScheduledPublication\Repository\ScheduledPublicationRepository;
use Doctrine\ORM\EntityManager;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;

class ScheduledPublicationFormDataPersister implements FormDataHandlerInterface
{

    private ScheduledPublicationRepository $scheduledPublicationRepository;

    private EntityManager $entityManager;

    public function __construct(ScheduledPublicationRepository $scheduledPublicationRepository, EntityManager $entityManager)
    {
        $this->scheduledPublicationRepository = $scheduledPublicationRepository;
        $this->entityManager = $entityManager;
    }

    public function create(array $data)
    {
        $scheduledPublication = new ScheduledPublication();
        $scheduledPublication->setObject($data['object']);
        $scheduledPublication->setIdObject($data['idObject']);
        $scheduledPublication->setStatus(ScheduledPublication::STATUS_WAITING);
        $dateTimeDue = (new  \DateTime($data['dueDate']));
        $scheduledPublication->setDueDate($dateTimeDue);

        $this->entityManager->persist($scheduledPublication);
        $this->entityManager->flush($scheduledPublication);

        return $scheduledPublication->getId();
    }

    public function update($id, array $data)
    {
        $scheduledPublication = $this->scheduledPublicationRepository->findOneById($id);

        if ($scheduledPublication instanceof ScheduledPublication) {
            $scheduledPublication->setObject($data['object']);
            $scheduledPublication->setIdObject($data['idObject']);
            $dateTimeDue = (new  \DateTime($data['dueDate']));
            $scheduledPublication->setDueDate($dateTimeDue);

            $this->entityManager->persist($scheduledPublication);
            $this->entityManager->flush($scheduledPublication);
        }
    }
}
