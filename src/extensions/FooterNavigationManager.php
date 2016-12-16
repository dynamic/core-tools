<?php

namespace Dynamic\CoreTools\Extensions;

use SilverStripe\ORM\DataExtension,
    SilverStripe\Forms\FieldList,
    SilverStripe\Forms\GridField\GridField,
    SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

/**
 * Class FooterNavigationManager
 * @package Dynamic\CoreTools\Extensions
 */
class FooterNavigationManager extends DataExtension
{
    /**
     * @var array
     */
    private static $has_many = array(
        'NavigationColumns' => 'Dynamic\\CoreTools\\Model\\NavigationColumn',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        // footer navigation
        if ($this->owner->ID) {
            $config = GridFieldConfig_RecordEditor::create();
            if (class_exists('GridFieldOrderableRows')) {
                $config->addComponent(new GridFieldOrderableRows('SortOrder'));
            }
            $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $config->removeComponentsByType('GridFieldDeleteAction');
            $config->addComponent(new GridFieldDeleteAction(false));
            $footerLinks = GridField::create('NavigationColumns', 'Navigation Columns', $this->owner->NavigationColumns()->sort('SortOrder'), $config);

            $fields->addFieldsToTab('Root.Footer', array(
                $footerLinks,
            ));
        }
    }
}