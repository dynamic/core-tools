<?php

class TemplateConfig extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'TitleLogo' => "Enum('Logo, Title', 'Title')",
        'Title' => 'Varchar(255)',
        'Slogan' => 'Varchar(255)',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'Logo' => 'Image'
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
        if ($this->owner->ClassName != 'SiteConfig') {
            $fields->removeByName([
                'Title',
                'Tagline',
                'Logo',
            ]);

            // options for logo or title display
            $logoOptions = array('Title' => 'Display Site Title and Slogan', 'Logo' => 'Display Logo');
            $ImageField = ImageUploadField::create('Logo')
                ->setFolderName('Uploads/Logo');

            $fields->addFieldsToTab('Root.Main', [
                OptionsetField::create('TitleLogo', 'Branding', $logoOptions),
                DisplayLogicWrapper::create(
                    TextField::create('Title', 'Site Title'),
                    TextField::create('Tagline', 'Site Tagline/Slogan')
                )->displayIf('TitleLogo')->isEqualTo('Title')->end(),
                DisplayLogicWrapper::create(
                    $ImageField
                )->displayIf('TitleLogo')->isEqualTo('Logo')->end(),
            ]);

        }
    }

    /**
     * @return mixed
     */
    public function getSiteLogo()
    {
        if ($this->owner->Logo()) {
            return $this->owner->Logo();
        }

        return false;
    }
}
