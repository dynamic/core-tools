<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Versioned\GridFieldArchiveAction;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;

/**
 * Class ManyLinksManager.
 *
 * @method \SilverStripe\ORM\ManyManyList ActionLinks()
 *
 * @property-read \SilverStripe\ORM\DataObject|\SilverStripe\ORM\ManyManyList
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
            $config = GridFieldConfig_RelationEditor::create();

            // LinkLabel
            $linkFields = FieldList::create(
                TextField::create(
                    'ManyMany[LinkLabel]',
                    'Link Label'
                )
            );

            $edittest = new GridFieldDetailForm();
            $edittest->setFields($linkFields);

            $config->removeComponentsByType([
                GridFieldAddExistingAutocompleter::class,
                GridFieldAddNewButton::class,
                GridFieldDetailForm::class,
                GridFieldSortableHeader::class,
                GridFieldArchiveAction::class,
            ])->addComponents([
                new GridFieldOrderableRows('SortOrder'),
                new GridFieldAddExistingSearchButton(),
                new GridFieldTitleHeader(),
                $edittest,
            ]);

            $config->getComponentByType(GridFieldDataColumns::class)
                ->setDisplayFields(array(
                    'MenuTitle' => 'Menu Title',
                    'URLSegment' => 'URLSegment',
                    'LinkLabel' => 'Link Label',
                ));

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
