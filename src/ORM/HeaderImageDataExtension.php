<?php

namespace Dynamic\CoreTools\ORM;

use Dynamic\CoreTools\Model\HeaderImage;
use SilverShop\HasOneField\HasOneButtonField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LabelField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;

/**
 * Class HeaderImageDataExtension.
 *
 * @property int $HeaderImageID
 */
class HeaderImageDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $has_one = array(
        'HeaderImage' => HeaderImage::class,
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName("HeaderImageID");

        if ($this->owner->HeaderImage()->exists()) {
            $img_field = LiteralField::create("img", $this->owner->HeaderImage()->Image()->ScaleHeight(100));
        } else {
            $img_field = HiddenField::create('img', '', '');
        }

        $header_field = FieldGroup::create(
            $img_field,
            HasOneButtonField::create($this->owner, "HeaderImage", '', '')
        )->setTitle('Header Image');

        $fields->insertAfter(
            'Title',
            $header_field
        );
    }

    /**
     *
     */
    public function getPageHeaderImage()
    {
        if ($this->owner->HeaderImageID) {
            return $this->owner->HeaderImage();
        } else {
            return self::getParentHeaderImage($this->owner);
        }
    }

    /**
     * @param $page
     */
    private function getParentHeaderImage($page)
    {
        $parent = $page->Parent;
        if ($parent && $parent->HeaderImageID) {
            return $parent->HeaderImage();
        } elseif ($parent) {
            return self::getParentHeaderImage($parent);
        }

        return;
    }
}
