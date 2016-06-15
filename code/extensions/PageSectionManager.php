<?php

class PageSectionManager extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        // Sections
        $config = GridFieldConfig_RecordEditor::create();
        if (class_exists('GridFieldSortableRows')) {
            $config->addComponent(new GridFieldSortableRows('SortOrder'));
        }
        $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
        $config->removeComponentsByType('GridFieldDeleteAction');
        $config->addComponent(new GridFieldDeleteAction(false));
        $sectionsField = GridField::create('Sections', 'Sections', $this->owner->Sections()->sort('SortOrder'), $config);
        $fields->addFieldsToTab('Root.Sections', array(
            $sectionsField,
        ));
    }

    public function getPageSections()
    {
        return $this->owner->Sections()->sort('SortOrder');
    }
}
