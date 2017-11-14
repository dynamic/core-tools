<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;

/**
 * Class ManyLinksManager.
 */
class ManyLinksManager extends DataExtension
{
    /**
     * @var array
     */
    private static $many_many = array(
        'ActionLinks' => SiteTree::class,
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'ActionLinks' => array(
            'LinkLabel' => 'Varchar(255)',
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(array(
            'ActionLinks',
        ));

        if ($this->owner->ID) {
            $config = GridFieldConfig_RelationEditor::create()
                ->addComponent(new GridFieldOrderableRows('SortOrder'))
                ->addComponent(new GridFieldAddExistingSearchButton())
                ->removeComponentsByType('GridFieldAddExistingAutocompleter')
                ->removeComponentsByType('GridFieldAddNewButton');

            // LinkLabel
            $linkFields = FieldList::create(
                TextField::create(
                    'ManyMany[LinkLabel]',
                    'Link Label'
                )
            );

            $config->removeComponentsByType(new GridFieldDetailForm());
            $config->removeComponentsByType(new GridFieldDataColumns());

            $edittest = new GridFieldDetailForm();
            $edittest->setFields($linkFields);

            $summaryfieldsconf = new GridFieldDataColumns();
            $summaryfieldsconf->setDisplayFields(array(
                'MenuTitle' => 'Menu Title',
                'URLSegment' => 'URLSegment',
                'LinkLabel' => 'Link Label',
            ));

            $config->addComponent($edittest);
            $config->addComponent(
                $summaryfieldsconf,
                new GridFieldFilterHeader()
            );

            $linksField = GridField::create(
                'ActionLinks',
                'Links',
                $this->owner->ActionLinks()->sort('SortOrder'),
                $config
            );

            $fields->addFieldToTab('Root.Links', $linksField);
        }
    }
}
