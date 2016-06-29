<?php

/**
 * Class FileObject.
 *
 * Base class for simple file attachments. Intended not be used directly, but extended in projects.
 */
class FileObject extends ContentObject
{
    /**
     * @var string
     */
    private static $singular_name = 'File';

    /**
     * @var string
     */
    private static $plural_name = 'Files';

    /**
     * @var array
     */
    private static $db = array(
        'FileLink' => 'Varchar(255)',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Download' => 'File',
    );

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $file = UploadField::create('Download')
            ->setFolderName('Uploads/FileDownloads')
            ->setConfig('allowedMaxFileNumber', 1)
            ->setAllowedFileCategories('doc')
            ->setAllowedMaxFileNumber(1)
        ;

        $fields->addFieldsToTab('Root.Download', array(
            $file,
            TextField::create('FileLink')
                ->setDescription('URL of external file. will display on page if no Download is specified above.')
                ->setAttribute('placeholder', 'http://'),
        ));

        $fields->dataFieldByName('Image')
            ->setFolderName('Uploads/FileImages')
            ->setDescription('Preview image of file')
        ;

        return $fields;
    }
}
