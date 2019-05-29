<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class SpiffLegacyFieldsDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = [
        'Headline' => 'Varchar(255)',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->insertAfter(
            'Title',
            TextField::create('Headline')
        );
    }
}
