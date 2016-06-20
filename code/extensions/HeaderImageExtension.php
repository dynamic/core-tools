<?php

class HeaderImageExtension extends DataExtension
{
    private static $has_one = array(
        'HeaderImage' => 'Image',
    );

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
}
