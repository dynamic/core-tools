<?php

namespace Dynamic\CoreTools\Model;

use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Versioned\Versioned;

/**
 * Class ContentObject.
 *
 * @property string $Name
 * @property string $Title
 * @property \SilverStripe\ORM\FieldType\DBHTMLText $Content
 * @property int $ImageID
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
    private static $db = [
        'Title' => 'Varchar(255)',
        'ShowTitle' => 'Boolean',
        'Content' => 'HTMLText',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'Image' => Image::class,
    ];

    /**
     * @var string
     */
    private static $default_sort = 'Title ASC';

    /**
     * @var array
     */
    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Image',
        'Title' => 'Title',
    ];

    /**
     * @var array
     */
    private static $searchable_fields = [
        'Title' => 'Title',
    ];

    /**
     * @var array
     */
    private static $extensions = [
        Versioned::class,
    ];

    /**
     * @var bool
     */
    private static $versioned_gridfield_extensions = true;

    /**
     * @var string
     */
    private static $table_name = 'ContentObject';

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            // Add a combined field for "Title" and "Displayed" checkbox in a Bootstrap input group
            $fields->removeByName('ShowTitle');
            $fields->replaceField(
                'Title',
                TextCheckboxGroupField::create(
                    TextField::create('Title', _t(__CLASS__ . '.TitleLabel', 'Title (displayed if checked)')),
                    CheckboxField::create('ShowTitle', _t(__CLASS__ . '.ShowTitleLabel', 'Displayed'))
                )
                    ->setName('TitleAndDisplayed')
            );

            $ImageField = UploadField::create('Image', 'Image')
                ->setFolderName('Uploads/ContentObjects')
                ->setIsMultiUpload(false)
                ->setAllowedFileCategories('image');
            $ImageField->getValidator()
                ->setAllowedMaxFileSize(CORE_TOOLS_IMAGE_SIZE_LIMIT);

            $fields->insertBefore($ImageField, 'Content');
        });

        return parent::getCMSFields();
    }

    /**
     * @return \SilverStripe\ORM\ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Title) {
            $result->addError('Title is required before you can save');
        }

        return $result;
    }

    /**
     * Set permissions, allow all users to access by default.
     * Override in descendant classes, or use PermissionProvider.
     *
     * @param null $member
     * @param array $context
     *
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
