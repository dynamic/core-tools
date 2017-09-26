<?php

namespace Dynamic\CoreTools\ORM;

use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Model\SiteTree;

/**
 * Class TemplateConfig
 * @package Dynamic\CoreTools\Extensions
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
        'TitleLogo' => 'Title'
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
            'png'
        );
        $ImageField->setFolderName('Uploads/Logo');
        $ImageField->setIsMultiUpload(false);

        // options for logo or title display
        $logoOptions = array(
            'Title' => 'Display Site Title and Slogan',
            'Logo' => 'Display Logo'
        );

        $fields->addFieldsToTab('Root.Header', array(
            OptionsetField::create('TitleLogo', 'Branding', $logoOptions),
            $ImageField
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
