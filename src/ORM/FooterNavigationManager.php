<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Dynamic\CoreTools\Model\NavigationColumn;

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
      'NavigationColumns' => NavigationColumn::class,
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        // footer navigation
        if ($this->owner->ID) {
            $config = GridFieldConfig_RecordEditor::create();
            $config->addComponent(new GridFieldOrderableRows('SortOrder'));
            $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $config->removeComponentsByType('GridFieldDeleteAction');
            $config->addComponent(new GridFieldDeleteAction(false));
            $footerLinks = GridField::create('NavigationColumns',
              'Navigation Columns',
              $this->owner->NavigationColumns()->sort('SortOrder'), $config);

            $fields->addFieldsToTab('Root.Footer', array(
              $footerLinks,
            ));
        }
    }
}