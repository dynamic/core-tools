<?php

class PreviewExtension extends DataExtension
{
    private static $db = array(
        'PreviewTitle' => 'HTMLVarchar',
        'Abstract' => 'HTMLText',
    );

    private static $has_one = array(
        'PreviewImage' => 'Image',
    );

    public function updateCMSFields(FieldList $fields)
    {
        $ThumbField = UploadField::create('PreviewImage')
            ->setFolderName('Uploads/Preview')
            ->setConfig('allowedMaxFileNumber', 1)
        ;
        $ThumbField->getValidator()->allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
        if ($this->owner->stat('customThumbnailTitle')) {
            $ThumbField->setRightTitle($this->owner->stat('customThumbnailTitle'));
        } else {
            $ThumbField->setRightTitle('Small image displayed in summary');
        }
        $ThumbField->getValidator()->setAllowedMaxFileSize(CORE_TOOLS_IMAGE_SIZE_LIMIT);

        // Preview
        $fields->addFieldsToTab('Root.Preview', array(
            TextField::create('PreviewTitle', 'Preview Title')
                ->setDescription('If empty, will default to Page Name'),
            $abstract = TextareaField::create('Abstract')
                ->setDescription('If empty, will default to first paragraph of Content'),
            $ThumbField,
        ));

        if (class_exists('DisplayLogicFormField')) {
            $abstract->displayUnless('AbstractFirstParagraph')->isChecked();
        }
    }

    // getters for summary view
    public function getPreviewHeadline()
    {
        if ($this->owner->PreviewTitle) {
            return $this->owner->obj('PreviewTitle');
        } elseif ($this->owner->Title) {
            return $this->owner->Title;
        }

        return false;
    }

    public function getPreviewThumb()
    {
        if ($this->owner->PreviewImageID) {
            return $this->owner->PreviewImage();
        } elseif ($this->owner->ImageID) {
            return $this->owner->Image();
        }

        return false;
    }

    public function getPreviewAbstract()
    {
        if (!$this->owner->AbstractFirstParagraph && $this->owner->Abstract) {
            return $this->owner->Abstract;
        } elseif ((!$this->owner->AbstractFirstParagraph && !$this->owner->Abstract) || $this->owner->AbstractFirstParagraph) {
            $content = $this->owner->obj('Content');
            return $content->FirstParagraph();
        }
    }
}
