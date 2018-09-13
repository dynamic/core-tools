<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class CMSDesign extends DataExtension
{
    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        if ($fields->dataFieldByName('MenuTitle')) {
            $fields->insertBefore(
                'MetaDescription',
                $fields->dataFieldByName('MenuTitle')
            );
        }
        if ($fields->dataFieldByName('URLSegment')) {
            $fields->insertBefore(
                'MetaDescription',
                $fields->dataFieldByName('URLSegment')
            );
        }
    }
}
