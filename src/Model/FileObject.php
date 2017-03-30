<?php

namespace Dynamic\CoreTools\Model;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\TextField;
use SilverStripe\Assets\File;

/**
 * Class FileObject
 * @package Dynamic\CoreTools\Model
 *
 * Base class for simple file attachments. Intended not be used directly, but extended in projects.
 *
 * @property string $FileLink
 * @property int $DownloadID
 * @method File $Download
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
      'Download' => File::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'FileObject';

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $file = UploadField::create('Download')
          ->setFolderName('Uploads/FileDownloads')
          ->setConfig('allowedMaxFileNumber', 1)
          ->setAllowedFileCategories('doc')
          ->setAllowedMaxFileNumber(1);

        $fields->addFieldsToTab('Root.Download', array(
          $file,
          TextField::create('FileLink')
            ->setDescription('URL of external file. will display on page if no Download is specified above.')
            ->setAttribute('placeholder', 'http://'),
        ));

        $fields->dataFieldByName('Image')
          ->setFolderName('Uploads/FileImages')
          ->setDescription('Preview image of file');

        return $fields;
    }

    /**
     * @return bool|string
     */
    public function getFileLinkURL()
    {
        if ($this->DownloadID > 0) {
            return $this->Download()->Filename;
        }
        if ($this->FileLink) {
            return $this->FileLink;
        }
        return false;
    }

}
