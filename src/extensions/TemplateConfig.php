<?php

namespace Dynamic\CoreTools\Extensions;

use SilverStripe\ORM\DataExtension,
    SilverStripe\Forms\FieldList,
    SilverStripe\Forms\UploadField,
    SilverStripe\Forms\OptionsetField,
    SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor,
    SilverStripe\Forms\GridField\GridField;

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
        'TitleLogo' => "Enum('Logo, Title', 'Title')",
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Logo' => 'SilverStripe\\Assets\\Image'
    );

    /**
     * @var array
     */
    private static $many_many = array(
        'FooterLinks' => 'SilverStripe\\CMS\\Model\\SiteTree'
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'FooterLinks' => array(
            'SortOrder' => 'Int'
        )
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
        $ImageField->getValidator()->allowedExtensions = array('jpg', 'gif', 'png');
        $ImageField->setFolderName('Uploads/Logo');
        $ImageField->setConfig('allowedMaxFileNumber', 1);

        // options for logo or title display
        $logoOptions = array('Title' => 'Display Site Title and Slogan', 'Logo' => 'Display Logo');

        $fields->addFieldsToTab('Root.Header', array(
            OptionsetField::create('TitleLogo', 'Branding', $logoOptions),
            $ImageField
        ));

        $config = GridFieldConfig_RelationEditor::create();
        if (class_exists('GridFieldSortableRows')) {
            $config->addComponent(new GridFieldSortableRows("SortOrder"));
        }

        $FooterGridField = GridField::create("FooterLinks", "Footer Links", $this->owner->FooterLinks()->sort('SortOrder'), $config);

        // add FlexSlider, width and height
        $fields->addFieldsToTab("Root.Footer", array(
            $FooterGridField
        ));
    }

    /**
     * @return mixed
     */
    public function getSiteLogo()
    {
        return ($this->owner->Logo()) ? $this->owner->Logo() : false;
    }

    /**
     * @return mixed
     */
    public function getFooterLinkList()
    {
        return ($this->owner->FooterLinks()->exists()) ? $this->owner->FooterLinks()->sort('SortOrder') : false;
    }

}
