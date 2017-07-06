<?php

namespace Dynamic\CoreTools\Tests\TestOnly\Object;

use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Dev\TestOnly;
use Dynamic\CoreTools\ORM\FooterNavigationManager;

/**
 * Class FooterSiteConfig
 * @package Dynamic\CoreTools\Tests\TestOnly\Object
 */
class FooterSiteConfig extends SiteConfig implements TestOnly
{
    private static $extensions = [FooterNavigationManager::class];

    /**
     * @var string
     */
    private static $table_name = 'FooterSiteConfig_Test';
}
