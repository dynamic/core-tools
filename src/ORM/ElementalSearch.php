<?php

namespace Dynamic\CoreTools\ORM;

use DNADesign\Elemental\Models\ElementalArea;
use DNADesign\Elemental\Models\ElementContent;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\ORM\Connect\MySQLSchemaManager;
use SilverStripe\ORM\DataExtension;

class ElementalSearch extends DataExtension
{
    /**
     * @var array
     */
    private static $db = [
        'SearchContent' => 'HTMLText',
    ];

    /**
     * @var array
     */
    private static $indexes = [
        'SearchFields' => [
            'type' => 'fulltext',
            'columns' => ['SearchContent'],
        ]
    ];

    private static $create_table_options = [
        MySQLSchemaManager::ID => 'ENGINE=MyISAM'
    ];

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $content = $fields->dataFieldByName('ElementalArea');
        if ($content) {
            $fields->insertBefore(
                'ElementalArea',
                HeaderField::create('MainContentHD', 'Content Blocks', 4)
            );
        }
    }

    /**
     * @return array
     */
    public function seoContentFields()
    {
        return [
            'SearchContent'
        ];
    }

    /**
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        // create content block placeholder
        if (!$this->owner->ID) {
            if (!$this->owner->ElementAreaID) {
                $area = ElementalArea::create();
                $area->write();

                $this->owner->ElementAreaID = $area->ID;
            }
            $content = ElementContent::create();
            $content->Title = "Main Content";
            $content->ParentID = $this->owner->ElementalArea()->ID;
            $content->write();
        }

        // set Content to output of blocks for search
        $this->owner->SearchContent = $this->owner->getElementsForSearch();
    }
}
