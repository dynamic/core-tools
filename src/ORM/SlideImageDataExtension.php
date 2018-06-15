<?php

namespace Dynamic\CoreTools\ORM;

use Sheadawson\Linkable\Forms\LinkField;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class SlideImageDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $has_one = [
          'SlideLink' => Link::class,
    ];

    /**
     * @param FieldList $fields
     */
    public function updateSlideImageFields(FieldList $fields)
    {
        $fields->removeByName([
            'PageID',
            'PageLinkID',
            'SlideLinkID',
        ]);

        $fields->addFieldsToTab('Root.Main', [
            LinkField::create('SlideLinkID', 'Link'),
        ]);
    }
}
