<?php

namespace Dynamic\CoreTools\ORM;

use Dynamic\SilverStripeGeocoder\Form\GoogleMapField;
use Dynamic\SilverStripeGeocoder\GoogleGeocoder;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxField;

/**
 * Class CompanyConfig
 * @package Dynamic\CoreTools\Extensions
 *
 * @property string $CompanyName
 * @property string $Phone
 * @property string $Email
 * @property bool $ShowDirections
 * @property string $Hours
 */
class CompanyConfig extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'CompanyName' => 'Varchar(200)',
        'Phone' => 'Varchar(20)',
        'Email' => 'Varchar(100)',
        'Hours' => 'Text',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Company.Contact', array(
            HeaderField::create('CompanyHD', 'Company', 1),
            HeaderField::create('CompanyInfo', 'Company Information', 2),
            LiteralField::create(
                'EnterInfo',
                '<p>Enter your company contact information, which will be available throughout your website</p>'
            ),
            TextField::create('CompanyName', 'Company Name'),
            TextField::create('Phone', 'Phone'),
            TextField::create('Email', 'Email'),
            TextareaField::create('Hours')
        ));

        /*
        if ($this->owner->hasAddress()) {
            $key = Config::inst()->get(GoogleGeocoder::class, 'geocoder_api_key');

            $field = GoogleMapField::create('LocationMap', [
                "height" => "300px",
                "lng" => $this->owner->Lat,
                "lat" => $this->owner->Lng,
            ]);

            $fields->insertAfter(LiteralField::create('LocationMap', $field), 'ShowDirections');
        }
        */
    }
}
