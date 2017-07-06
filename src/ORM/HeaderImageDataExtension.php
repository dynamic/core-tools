<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;

/**
 * Class HeaderImageDataExtension
 * @package Dynamic\CoreTools\Extensions
 *
 * @property int $HeaderImageID
 */
class HeaderImageDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $has_one = array(
        'HeaderImage' => Image::class,
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $ImageField = UploadField::create('HeaderImage', 'Header Image')
            ->setFolderName('Uploads/HeaderImages')
            ->setIsMultiUpload(false);
        $ImageField->getValidator()->allowedExtensions = array(
            'jpg',
            'jpeg',
            'gif',
            'png'
        );
        $ImageField->getValidator()
            ->setAllowedMaxFileSize(CORE_TOOLS_IMAGE_SIZE_LIMIT);
        $fields->addFieldsToTab('Root.Images', array(
            $ImageField,
        ));
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
