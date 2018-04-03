<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class SiteTreeSubTitleExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'SubTitle' => 'Varchar(255)',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->insertAfter(
            TextField::create('SubTitle', 'Sub Title'),
            'MenuTitle'
        );
    }
}
