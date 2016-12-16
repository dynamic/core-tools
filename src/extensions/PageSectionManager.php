<?php

namespace Dynamic\CoreTools\Extensions;

use SilverStripe\ORM\DataExtension,
    SilverStripe\Forms\FieldList,
    SilverStripe\Forms\GridField\GridField,
    SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor,
    SilverStripe\Forms\GridField\GridFieldDeleteAction;

/**
 * Class PageSectionManager
 * @package Dynamic\CoreTools\Extensions
 */
class PageSectionManager extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->ID) {
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
    }

    public function getPageSections()
    {
        return $this->owner->Sections()->sort('SortOrder');
    }
}

/**
 * Class PageSectionRelation
 * @package Dynamic\CoreTools\Extensions
 */
class PageSectionRelation extends DataExtension
{
    private static $has_many = array(
        'Sections' => 'Dynamic\\CoreTools\\Model\\PageSection',
    );
}
