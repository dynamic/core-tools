<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Assets\Image;

/**
 * Class TemplateConfig.
 *
 * @property string $TitleLogo
 * @property int $LogoID
 */
class TemplateConfig extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'TitleLogo' => "Enum(array('Logo', 'Title'))",
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Logo' => Image::class,
    );

    /**
     * @var array
     */
    private static $defaults = array(
        'TitleLogo' => 'Title',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $ImageField = UploadField::create('Logo');
        $ImageField->getValidator()->allowedExtensions = array(
            'jpg',
            'gif',
            'png',
        );
        $ImageField->setFolderName('Uploads/Logo');
        $ImageField->setIsMultiUpload(false);

        // options for logo or title display
        $logoOptions = array(
            'Logo' => 'Display Logo',
            'Title' => 'Display Site Title and Slogan',
        );

        $fields->addFieldsToTab('Root.Template.Header', array(
            HeaderField::create('HeaderHD', 'Header', 1),
            LiteralField::create('HeaderDescrip', '<p>Adjust the settings of your theme header.</p>'),
            HeaderField::create('BrandingHD', 'Branding', 2),
            OptionsetField::create('TitleLogo', 'Branding', $logoOptions),
            $ImageField,
        ));
    }

    /**
     * @return mixed
     */
    public function getSiteLogo()
    {
        return ($this->owner->Logo()) ?? false;
    }

    /**
     * @return mixed
     */
    public function getFooterLinkList()
    {
        return ($this->owner->FooterLinks()
            ->exists()) ? $this->owner->FooterLinks()
            ->sort('SortOrder') : false;
    }
}
