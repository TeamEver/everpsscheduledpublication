<?php


    namespace Ever\ScheduledPublication\Form;

use Ever\ScheduledPublication\Entity\ScheduledPublication;
use Ever\ScheduledPublication\Repository\ScheduledPublicationRepository;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;
use Symfony\Component\Serializer\Serializer;

class ScheduledPublicationFormDataProvider implements FormDataProviderInterface
{
    private ScheduledPublicationRepository $scheduledPublicationRepository;

    private Serializer $serializer;

    public function __construct(ScheduledPublicationRepository $scheduledPublicationRepository, Serializer $serializer)
    {
        $this->scheduledPublicationRepository = $scheduledPublicationRepository;
        $this->serializer = $serializer;
    }

    public function getData($id)
    {
        $scheduledPublication = $this->scheduledPublicationRepository->findOneById($id);

        if ($scheduledPublication instanceof ScheduledPublication) {
            $tab = $this->serializer->normalize($scheduledPublication, null);
            return $tab;
        }

        return [];
    }


    public function getDefaultData()
    {
    }
}
