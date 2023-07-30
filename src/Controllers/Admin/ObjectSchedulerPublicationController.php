<?php

    namespace Ever\ScheduledPublication\Controllers\Admin;

    use Ever\ScheduledPublication\Entity\ScheduledPublication;
    use Ever\ScheduledPublication\Grid\ScheduledPublicationFilters;
    use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\Handler\FormHandler;
    use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\Builder\FormBuilder;

class ObjectSchedulerPublicationController extends FrameworkBundleAdminController
{

    public function listAction(Request $request, ScheduledPublicationFilters $scheduledPublicationFilters)
    {
        $scheduledPublicationGridFactory = $this->get('Ever.scheduledpublication.grid.scheduled_publication_grid_factory');

        $scheduledPublicationFilters->addFilter(['status' => ScheduledPublication::STATUS_WAITING]);
        $scheduledPublicationGridWaiting = $scheduledPublicationGridFactory->getGrid($scheduledPublicationFilters);
        $gridWaiting = $this->presentGrid($scheduledPublicationGridWaiting);

        $scheduledPublicationFilters->addFilter(['status' => ScheduledPublication::STATUS_DONE]);
        $scheduledPublicationGridDone = $scheduledPublicationGridFactory->getGrid($scheduledPublicationFilters);
        $gridDone = $this->presentGrid($scheduledPublicationGridDone);

        return $this->render('@Modules/everpsscheduledpublication/views/templates/admin/scheduledpublication/list.html.twig', ['gridWaiting' => $gridWaiting, 'gridDone' => $gridDone, 'layoutHeaderToolbarBtn' => $this->getToolbarButtons()]);
    }

    public function createAction(Request $request)
    {
        /** @var FormBuilder $formBuilder */
        $formBuilder = $this->get('ever.scheduledpublication.form.builder.scheduled_publication_form_builder');
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var FormHandler $formDataPersister */
            $formDataPersister = $this->get('ever.scheduledpublication.form.identifiable_object.handler.scheduled_publication_form_handler');
            $result = $formDataPersister->handle($form);

            if ($result->getIdentifiableObjectId() !== null) {
                $this->addFlash('success', $this->trans('La publication programmée a bien été enregistré', \everpsscheduledpublication::getTranslationDomain(), []));
                return $this->redirectToRoute('admin_scheduled_publication_list');
            }

            $this->addFlash('error', $this->trans('Impossible de sauvegarder la publication programmée', \everpsscheduledpublication::getTranslationDomain(), []));
        }

        return $this->render('@Modules/everpsscheduledpublication/views/templates/admin/scheduledpublication/create.html.twig', ['form' => $form->createView()]);
    }

    public function editAction(Request $request, int $id)
    {

        $formBuilder = $this->get('ever.scheduledpublication.form.builder.scheduled_publication_form_builder');
        $form = $formBuilder->getFormFor($id);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var FormHandler $formDataPersister */
            $formDataPersister = $this->get('ever.scheduledpublication.form.identifiable_object.handler.scheduled_publication_form_handler');
            $result = $formDataPersister->handleFor($id, $form);

            if ($result->isSubmitted() && $result->isValid()) {
                $this->addFlash('success', $this->trans('La publication programmé à bien était mise à jour.', \everpsscheduledpublication::getTranslationDomain()));
                return $this->redirectToRoute('admin_scheduled_publication_list');
            }

            $this->addFlash('error', $this->trans('Impossible de sauvegarder la publication programmée', \everpsscheduledpublication::getTranslationDomain(), []));
        }

        return $this->render('@Modules/everpsscheduledpublication/views/templates/admin/scheduledpublication/edit.html.twig', ['form' => $form->createView(), 'id' => $id]);
    }

    public function deleteAction(Request $request, string $id)
    {
        return new Response('DeleteAction');
    }


    /**
     * Gets the header toolbar buttons.
     *
     * @return array
     */
    private function getToolbarButtons()
    {
        return [
            'add' => [
                'href' => $this->generateUrl('admin_scheduled_publication_create'),
                'desc' => $this->trans('Nouvelle publication programmée', \everpsscheduledpublication::getTranslationDomain()),
                'icon' => 'add_circle_outline',
            ],
        ];
    }
}
