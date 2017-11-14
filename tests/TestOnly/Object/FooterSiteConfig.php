<?php

namespace Dynamic\CoreTools\Tests\TestOnly\Object;

use Dynamic\CoreTools\Model\GlobalSiteSetting;
use SilverStripe\Dev\TestOnly;
use Dynamic\CoreTools\ORM\FooterNavigationManager;

/**
 * Class FooterSiteConfig.
 */
class FooterSiteConfig extends GlobalSiteSetting implements TestOnly
{
    /**
     * @var array
     */
    private static $extensions = [FooterNavigationManager::class];

    /**
     * @var string
     */
    private static $table_name = 'FooterSiteConfig_Test';
}
