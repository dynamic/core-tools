<?php

namespace Dynamic\CoreTools\Migration;

use Dynamic\CompanyConfig\Model\CompanyConfigSetting;
use Dynamic\TemplateConfig\Model\NavigationColumn;
use Dynamic\TemplateConfig\Model\TemplateConfigSetting;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataExtension;
use Symbiote\Addressable\Addressable;
use Symbiote\Addressable\Geocodable;
use Symbiote\GridFieldExtensions\GridFieldAddExistingSearchButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class GlobalConfigMigration extends DataExtension
{
    /**
     * @var array
     */
    private static $many_many = array(
        'UtilityLinks' => SiteTree::class,
    );
    
    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'UtilityLinks' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function onAfterWrite()
    {
        parent::onAfterWrite();
        
        $template = TemplateConfigSetting::current_template_config();

        foreach ($this->owner->UtilityLinks() as $link) {
            $template->UtilityLinks()->add($link);
        }
    }
}
