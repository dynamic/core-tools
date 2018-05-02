<?php

namespace Dynamic\Elements\ORM;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class ElementListLayoutExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = [
        'Columns' => 'Enum("1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12")',
        'Offset' => 'Enum("1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12", null)',
        'Order' => 'Enum("1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, first, last", null)',
        'Breakpoint' => 'Enum("sm, md, lg, xl")',
    ];

    private static $defaults = [
        'Columns' => 12,
        'Offset' => '',
        'Order' => '',
        'Breakpoint' => 'md'
    ];

    /**
     * @param FieldList $fields
     */
     public function updateCMSFields(FieldList $fields)
     {

         $fields->addFieldToTab(
             'Root.Layout',
             DropdownField::create(
                 'Columns',
                 'Columns',
                 $this->owner->dbObject('Columns')->enumValues()
             )
         );

         $fields->addFieldToTab(
             'Root.Layout',
             DropdownField::create(
                 'Offset',
                 'Offset',
                 $this->owner->dbObject('Offset')->enumValues()
             )->setEmptyString('Choose an option')
         );

         $fields->addFieldToTab(
             'Root.Layout',
             DropdownField::create(
                 'Order',
                 'Order',
                 $this->owner->dbObject('Order')->enumValues()
             )->setEmptyString('Choose an option')
         );

         $fields->addFieldToTab(
             'Root.Layout',
             DropdownField::create(
                 'Breakpoint',
                 'Breakpoint',
                 $this->owner->dbObject('Breakpoint')->enumValues()
             )
         );
     }
}
