<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class PageSectionManager
 * @package Dynamic\CoreTools\ORM
 */
class PageSectionManager extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->ID) {
            // Sections
            $config = GridFieldConfig_RecordEditor::create()
                ->addComponent(new GridFieldOrderableRows('SortOrder'))
                ->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                ->removeComponentsByType(GridFieldDeleteAction::class)
                ->addComponent(new GridFieldDeleteAction(false));
            $sectionsField = GridField::create(
                'Sections',
                'Sections',
                $this->owner->Sections()->sort('SortOrder'),
                $config
            );
            $fields->addFieldsToTab('Root.Sections', array(
                $sectionsField,
            ));
        }
    }

    /**
     * @return mixed
     */
    public function getPageSections()
    {
        return $this->owner->Sections()->sort('SortOrder');
    }
}
