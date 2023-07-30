<?php


    namespace Ever\ScheduledPublication\Grid;

use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\BadgeColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use Symfony\Component\VarDumper\Cloner\Data;

class ScheduledPublicationGridDefinitionFactory extends AbstractGridDefinitionFactory
{

    const GRID_ID = 'scheduled_publication';

    protected function getId()
    {
        'scheduled_publication';
    }

    protected function getName()
    {
        return $this->trans('Publications programmées', [], \everpsscheduledpublication::getTranslationDomain());
    }

    protected function getColumns()
    {
        $collection = new ColumnCollection();

        $columnId = new DataColumn('id_scheduledpublication');
        $columnId->setName($this->trans('ID', [], \everpsscheduledpublication::getTranslationDomain()));
        $columnId->setOptions(['field' => 'id_scheduledpublication']);

        $collection->add($columnId);

        $columnObject = new DataColumn('object');
        $columnObject->setName($this->trans('Type d\'objet', [], \everpsscheduledpublication::getTranslationDomain()));
        $columnObject->setOptions(['field' => 'object']);

        $collection->add($columnObject);

        $columnIdObject = new DataColumn('id_object');
        $columnIdObject->setName($this->trans('Id de l\'objet', [], \everpsscheduledpublication::getTranslationDomain()));
        $columnIdObject->setOptions(['field' => 'id_object']);

        $collection->add($columnIdObject);

        $columnDueDate = new DataColumn('due_date');
        $columnDueDate->setName($this->trans('Date de publication', [], \everpsscheduledpublication::getTranslationDomain()));
        $columnDueDate->setOptions(['field' => 'due_date']);

        $collection->add($columnDueDate);

        $columnStatus = new BadgeColumn('status');
        $columnStatus->setName($this->trans('Status', [], \everpsscheduledpublication::getTranslationDomain()));


        $columnDateAdd = new DataColumn('date_add');
        $columnDateAdd->setName($this->trans('Date de création', [], \everpsscheduledpublication::getTranslationDomain()));
        $columnDateAdd->setOptions(['field' => 'date_add']);

        $collection->add($columnDateAdd);

        $columnDateUpd = new DataColumn('date_upd');
        $columnDateUpd->setName($this->trans('Date de mise à jour', [], \everpsscheduledpublication::getTranslationDomain()));
        $columnDateUpd->setOptions(['field' => 'date_upd']);

        $collection->add($columnDateUpd);

        $rowCollectionAction = new RowActionCollection();

        $editLinkAction = new LinkRowAction('edit');
        $editLinkAction->setIcon('edit');
        $editLinkAction->setName($this->trans('Modifier', [], \everpsscheduledpublication::getTranslationDomain()));
        $editLinkAction->setOptions([
            'route' => 'admin_scheduled_publication_edit',
            'route_param_name' => 'id',
            'route_param_field' => 'id_scheduledpublication',
            'clickable_row' => true,
        ]);

        $deleteLinkAction = new LinkRowAction('delete');
        $deleteLinkAction->setIcon('delete');
        $deleteLinkAction->setName($this->trans('Supprimer', [], \everpsscheduledpublication::getTranslationDomain()));
        $deleteLinkAction->setOptions([
            'route' => 'admin_scheduled_publication_delete',
            'route_param_name' => 'id',
            'route_param_field' => 'id_scheduledpublication',
            'clickable_row' => true,
        ]);

        $rowCollectionAction->add($editLinkAction);
        $rowCollectionAction->add($deleteLinkAction);

        $columnActions = (new ActionColumn('actions'))->setOptions([
            'actions' => $rowCollectionAction,
        ]);

        $collection->add($columnActions);

        return $collection;
    }
}
