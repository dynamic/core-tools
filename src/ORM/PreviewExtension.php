<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;

/**
 * Class PreviewExtension
 * @package Dynamic\CoreTools\Extensions
 *
 * @property string $PreviewTitle
 * @property string $Abstract
 * @property int $PreviewImageID
 */
class PreviewExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'PreviewTitle' => 'HTMLVarchar(255)',
        'Abstract' => 'HTMLText',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'PreviewImage' => Image::class,
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(array(
            'PreviewTitle',
            'Abstract',
            'PreviewImage',
        ));

        $thumbnail = (class_exists('ImageUploadField'))
            ? ImageUploadField::create('PreviewImage')
            : UploadField::create('PreviewImage');
        $thumbnail->setFolderName('Uploads/Preview');

        // custom field description
        if ($this->owner->config()->customThumbnailTitle) {
            $thumbnail->setDescription($this->owner->config()->customThumbnailTitle);
        } else {
            $thumbnail->setDescription('optional, small image displayed with preview');
        }

        $previewFields = FieldList::create(
            TextField::create(
                'PreviewTitle',
                'Preview Title'
            )
                ->setAttribute('placeholder', $this->owner->getTitle())
                ->setDescription('optional, defaults to Page Name'),
            $abstract = HtmlEditorField::create('Abstract')
                ->setRows(5)
                ->setDescription('optional, defaults to first paragraph of Content'),
            $thumbnail
        );

        // Preview
        $previewField = ToggleCompositeField::create(
            'PreviewHD',
            'Custom Preview',
            $previewFields
        )
            ->setHeadingLevel(4)
            ->setStartClosed(true);
        $fields->addFieldToTab('Root.Main', $previewField);
    }

    /**
     * @return bool|string
     */
    public function getPreviewHeadline()
    {
        if ($this->owner->PreviewTitle) {
            return $this->owner->obj('PreviewTitle');
        } elseif ($this->owner->Title) {
            return $this->owner->Title;
        }
        return false;
    }

    /**
     * @return bool|\SilverStripe\Assets\Image
     */
    public function getPreviewThumb()
    {
        if ($this->owner->PreviewImageID) {
            return $this->owner->PreviewImage();
        } elseif ($this->owner->ImageID) {
            return $this->owner->Image();
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function getPreviewAbstract()
    {
        if (!$this->owner->AbstractFirstParagraph && $this->owner->Abstract) {
            return $this->owner->Abstract;
        } elseif ((
                !$this->owner->AbstractFirstParagraph && !$this->owner->Abstract
            ) || $this->owner->AbstractFirstParagraph
        ) {
            $content = $this->owner->obj('Content');

            return $content->FirstParagraph();
        }
        return false;
    }

}
