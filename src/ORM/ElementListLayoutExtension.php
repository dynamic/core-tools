<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

/**
 * Class ElementListLayoutExtension
 * @package Dynamic\CoreTools\ORM
 */
class ElementListLayoutExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = [
        'Columns' => 'Enum("3, 4, 6, 8, 9, 10, 12")',
    ];

    private static $defaults = [
        'Columns' => 12,
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
                [3 => 'One Quarter', 4 => 'One Third', 6 => 'Half', 8 => 'Two Thirds',
                 9 => 'Three Quarters', 10 => '10 Columns Centered', 12 => 'Full']
            )
        );
    }
}
