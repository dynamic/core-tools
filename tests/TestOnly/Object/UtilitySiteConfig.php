<?php

namespace Dynamic\CoreTools\Tests\TestOnly;

use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Dev\TestOnly;
use Dynamic\CoreTools\ORM\UtilityNavigationManager;

/**
 * Class UtilitySiteConfig
 * @package Dynamic\CoreTools\Tests\TestOnly
 */
class UtilitySiteConfig extends SiteConfig implements TestOnly
{
    private static $extensions = [UtilityNavigationManager::class];

    /**
     * @var string
     */
    private static $table_name = 'UtilitySiteConfig_Test';
}