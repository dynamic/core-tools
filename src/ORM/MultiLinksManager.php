<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\GridFieldExtensions\GridFieldAddExistingSearchButton;

/**
 * Class MultiLinksManager.
 */
class MultiLinksManager extends DataExtension
{
    /*
     * @var array
     */
    /*private static $many_many = [
      'ContentLinks' => 'Link',
    ];

    private static $many_many_extraFields = [
      'ContentLinks' => [
        'Sort' => 'Int',
      ],
    ];*/

    /*
     * @param FieldList $fields
     */
    /*public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
          'ContentLinks',
        ]);

        if ($this->owner->ID) {
            $config = GridFieldConfig_RelationEditor::create()
              ->addComponent(new GridFieldOrderableRows('Sort'))
              ->removeComponentsByType('GridFieldAddExistingAutocompleter')
              ->addComponent(new GridFieldAddExistingSearchButton());

            $links = GridField::create('ContentLinks', 'Links',
              $this->owner->ContentLinks()->sort('Sort'), $config);
            $fields->addFieldToTab('Root.Links', $links);
        }
    }*/
}
