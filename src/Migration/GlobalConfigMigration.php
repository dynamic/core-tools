<?php

namespace Dynamic\CoreTools\Migration;

use Dynamic\CompanyConfig\Model\CompanyConfigSetting;
use Dynamic\TemplateConfig\Model\TemplateConfigSetting;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataExtension;

class GlobalConfigMigration extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'CompanyName' => 'Varchar(200)',
    );
    
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

        $company = CompanyConfigSetting::current_company_config();
        $company->CompanyName = $this->owner->CompanyName;
        $company->write();
        
        $template = TemplateConfigSetting::current_template_config();
        foreach ($this->owner->UtilityLinks() as $link) {
            $template->UtilityLinks()->add($link);
        }
    }
}
