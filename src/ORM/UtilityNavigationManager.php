<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\GridFieldExtensions\GridFieldAddExistingSearchButton;

/**
 * Class UtilityNavigationManager
 * @package Dynamic\CoreTools\Extensions
 */
class UtilityNavigationManager extends DataExtension
{
    /**
     * @var array
     */
    private static $many_many = array(
      'UtilityLinks' => SiteTree::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
      'UtilityLinks' => array(
        'SortOrder' => 'Int',
      ),
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->ID) {
            $config = GridFieldConfig_RelationEditor::create()
              ->addComponent(new GridFieldOrderableRows('SortOrder'))
              ->removeComponentsByType('GridFieldAddExistingAutocompleter')
              ->addComponent(new GridFieldAddExistingSearchButton())
              ->removeComponentsByType('GridFieldAddNewButton');
            $promos = $this->owner->UtilityLinks()->sort('SortOrder');
            $linksField = GridField::create('UtilityLinks', 'Utility Links',
              $promos, $config);

            $fields->addFieldsToTab('Root.Utility', array(
              $linksField,
            ));
        }
    }

}