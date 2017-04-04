<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\GridFieldExtensions\GridFieldOrderableRows;
use Dynamic\CoreTools\Model\PageSection;

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
            $config = GridFieldConfig_RecordEditor::create()
                ->addComponent(new GridFieldOrderableRows('SortOrder'))
                ->removeComponentsByType('GridFieldAddExistingAutocompleter')
                ->removeComponentsByType('GridFieldDeleteAction')
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
        'Sections' => PageSection::class,
    );
}
