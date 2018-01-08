<?php

/**
 * A GridField action to handle soft delete
 */
class GridFieldUnArchiveAction implements GridField_ColumnProvider, GridField_ActionProvider
{
    /**
     * Add a column 'Delete'
     *
     * @param GridField $gridField
     * @param array $columns
     */
    public function augmentColumns($gridField, &$columns)
    {
        if (!in_array('Actions', $columns)) {
            $columns[] = 'Actions';
        }
    }

    /**
     * Return any special attributes that will be used for FormField::create_tag()
     *
     * @param GridField $gridField
     * @param DataObject $record
     * @param string $columnName
     * @return array
     */
    public function getColumnAttributes($gridField, $record, $columnName)
    {
        return array('class' => 'col-buttons');
    }

    /**
     * Add the title
     *
     * @param GridField $gridField
     * @param string $columnName
     * @return array
     */
    public function getColumnMetadata($gridField, $columnName)
    {
        if ($columnName == 'Actions') {
            return array('title' => '');
        }
    }

    /**
     * Which columns are handled by this component
     *
     * @param GridField $gridField
     * @return array
     */
    public function getColumnsHandled($gridField)
    {
        return array('Actions');
    }

    /**
     * Which GridField actions are this component handling
     *
     * @param GridField $gridField
     * @return array
     */
    public function getActions($gridField)
    {
        return array('restore');
    }

    /**
     * @param GridField $gridField
     * @param DataObject $record
     * @param string $columnName
     * @return string - the HTML for the column
     */
    public function getColumnContent($gridField, $record, $columnName)
    {
        if (!$record->canDelete()) return;

        $field = GridField_FormAction::create($gridField,
            'restore'.$record->ID, false, "restore",
            array('RecordID' => $record->ID))
            ->addExtraClass('gridfield-button-restore')
            ->setAttribute('title', 'Restore Record')
            ->setAttribute('data-icon', 'restore')
            ->setDescription('Restore Record');

        return $field->Field();
    }

    /**
     * Handle the actions and apply any changes to the GridField
     *
     * @param GridField $gridField
     * @param $actionName
     * @param $arguments
     * @param $data
     *
     * @throws ValidationException
     */
    public function handleAction(GridField $gridField, $actionName, $arguments,
        $data)
    {
        if ($actionName == 'restore') {
            $item = $gridField->getList()->byID($arguments['RecordID']);
            if (!$item) {
                return;
            }

            if (!$item->canDelete()) {
                throw new ValidationException(
                    _t('GridFieldAction_Delete.DeletePermissionsFailure',
                        "No delete permissions"), 0);
            }

            $item->undoDelete();
        }
    }
}
