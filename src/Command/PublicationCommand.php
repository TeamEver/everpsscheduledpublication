<?php

    namespace Ever\ScheduledPublication\Command;

use Ever\ScheduledPublication\Entity\ScheduledPublication;
use Ever\ScheduledPublication\Repository\ScheduledPublicationRepository;
use Doctrine\ORM\EntityManager;
use PrestaShop\PrestaShop\Adapter\Validate;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

class PublicationCommand extends Command
{

    private ScheduledPublicationRepository $scheduledPublicationRepository;

    private EntityManager $entityManager;

    public function __construct(ScheduledPublicationRepository $scheduledPublicationRepository, EntityManager $entityManager)
    {
        $this->scheduledPublicationRepository = $scheduledPublicationRepository;
        $this->entityManager = $entityManager;
        parent::__construct();
    }


    public function configure()
    {
        $this->setDescription('Publish object in waiting list');
        $this->setName('ever:scheduledpublication:publication');
    }

    private $verbosityLevelMap = [
                LogLevel::ERROR => OutputInterface::VERBOSITY_NORMAL,
                LogLevel::INFO   => OutputInterface::VERBOSITY_NORMAL,
            ];

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = new ConsoleLogger($output,$this->verbosityLevelMap);

        $objectWaitingList = $this->scheduledPublicationRepository->findByStatus(ScheduledPublication::STATUS_WAITING);
        $dateNow = new \DateTime('now');

        if ($objectWaitingList) {
            $nbObjectInWaitingList = count($objectWaitingList);
            $logger->info('Il y a ' . $nbObjectInWaitingList . ' en attente de publication');

            /** @var ScheduledPublication $scheduledPublication */
            foreach ($objectWaitingList as $scheduledPublication) {
                $error = false;
                $dateDiff = $scheduledPublication->getDueDate()->diff($dateNow);

                if ($dateDiff->invert === 0) {
                    $logger->info('L\'objet classe : ' . $scheduledPublication->getObject() . ' avec l\'id ' . $scheduledPublication->getIdObject() .  ' va être publié');
                    //publish object
                    $class = $scheduledPublication->getObject();
                    $idObject = $scheduledPublication->getIdObject();

                    if (class_exists($class)) {
                        $object = new $class($idObject);
                        if (Validate::isLoadedObject($object)) {
                            if (property_exists($object, 'active')) {
                                $logger->info('set active à true');
                                $object->active = true;
                            }

                            if (property_exists($object, 'visibility')) {
                                $object->visibility = 'both';
                                $logger->info('set visibility à both');
                            }

                            if ($object->save()) {
                                $logger->info('L\'objet classe : ' . $scheduledPublication->getObject() . ' avec l\'id ' . $scheduledPublication->getIdObject() . ' a été sauvegardé');
                            } else {
                                $logger->error('L\'objet classe : ' . $scheduledPublication->getObject() . ' avec l\'id ' . $scheduledPublication->getIdObject() . ' n\'a pas pu être sauvegardé');
                                $error = true;
                            }

                        } else {
                            $logger->error('L\'objet classe : ' . $scheduledPublication->getObject() . ' avec l\'id ' . $scheduledPublication->getIdObject() . ' n\'est pas un objet valide Prestashop');
                            $error = true;
                        }
                    }
                    if (!$error) {
                        //Mise à jour de la publication programmée
                        $scheduledPublication->setStatus(ScheduledPublication::STATUS_DONE);
                        $this->entityManager->persist($scheduledPublication);
                        $this->entityManager->flush();
                    }
                }


            }
        }

    }

}
