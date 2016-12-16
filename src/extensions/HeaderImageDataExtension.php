<?php

namespace Dynamic\CoreTools\Extensions;

use SilverStripe\ORM\DataExtension,
    SilverStripe\Forms\FieldList,
    SilverStripe\Forms\UploadField;

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
        'HeaderImage' => 'SilverStripe\\Assets\\Image',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $ImageField = UploadField::create('HeaderImage', 'Header Image')
            ->setFolderName('Uploads/HeaderImages')
            ->setConfig('allowedMaxFileNumber', 1)
        ;
        $ImageField->getValidator()->allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
        $ImageField->getValidator()->setAllowedMaxFileSize(CORE_TOOLS_IMAGE_SIZE_LIMIT);
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