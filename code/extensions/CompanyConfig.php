<?php

class CompanyConfig extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'CompanyName' => 'Varchar(200)',
        'Phone' => 'Varchar(20)',
        'Email' => 'Varchar(100)',
        'ShowDirections' => 'Boolean',
        'Hours' => 'Text',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Address', array(
            HeaderField::create('CompanyInfo', 'Company Information'),
            LiteralField::create('EnterInfo',
                '<p>Enter your company contact information, which will be used throughout your website</p>'),
            TextField::create('CompanyName', 'Company Name'),
            TextField::create('Phone', 'Phone'),
            TextField::create('Email', 'Email'),
            TextareaField::create('Hours')
        ));

        $fields->addFieldToTab('Root.Address', CheckboxField::create('ShowDirections', 'Show Map and Driving Directions'));
    }
}
