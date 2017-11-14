<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class GoogleAnalyticsConfig extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'GACode' => 'Varchar(16)',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Main', array(
            HeaderField::create('AnalyticsHD', 'Google Analytics', 1),
            HeaderField::create('ProfileHD', 'Profile ID', 2),
            LiteralField::create(
                'AnalyticsDescrip',
                '<p>Enter your Google Analytics Profile ID below to enable site tracking</p>'
            ),
            $gaCode = TextField::create('GACode', 'Google Analytics'),
        ));

        $gaCode->setDescription('Google Analytics Profile ID (in the format <strong>UA-XXXXX-X</strong>)');
    }
}
