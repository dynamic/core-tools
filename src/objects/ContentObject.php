<?php

namespace Dynamic\CoreTools\Model;

use SilverStripe\ORM\DataObject,
    SilverStripe\Forms\UploadField;

/**
 * Class ContentObject
 * @package Dynamic\CoreTools\Model
 */
class ContentObject extends DataObject
{
    /**
     * @var string
     */
    private static $singular_name = 'Content Object';

    /**
     * @var string
     */
    private static $plural_name = 'Content Objects';

    /**
     * @var array
     */
    private static $db = array(
        'Name' => 'Varchar(255)',
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Image' => 'SilverStripe\\Asstes\\Image',
    );

    /**
     * @var string
     */
    private static $default_sort = 'Name ASC';

    /**
     * @var array
     */
    private static $summary_fields = array(
        'Image.CMSThumbnail' => 'Image',
        'Name' => 'Name',
        'Title' => 'Title',
    );

    /**
     * @var array
     */
    private static $searchable_fields = array(
        'Name' => 'Name',
        'Title' => 'Title',
    );

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->dataFieldByName('Name')->setDescription('For internal reference only');

        $ImageField = UploadField::create('Image', 'Image')
            ->setFolderName('Uploads/ContentObjects')
            ->setConfig('allowedMaxFileNumber', 1)
            ->setAllowedFileCategories('image')
            ->setAllowedMaxFileNumber(1);
        $ImageField->getValidator()->setAllowedMaxFileSize(CORE_TOOLS_IMAGE_SIZE_LIMIT);

        $fields->insertBefore($ImageField, 'Content');

        return $fields;
    }

    /**
     * @return \SilverStripe\ORM\ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Name) {
            $result->error('Name is requied before you can save');
        }

        return $result;
    }

    /**
     * Set permissions, allow all users to access by default.
     * Override in descendant classes, or use PermissionProvider.
     *
     * @param null $member
     * @param array $context
     * @return bool
     */
    public function canCreate($member = null, $context = [])
    {
        return true;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canEdit($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canDelete($member = null)
    {
        return true;
    }

}