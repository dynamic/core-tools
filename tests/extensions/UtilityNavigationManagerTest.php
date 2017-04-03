<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Dev\TestOnly;

/**
 * Class UtilityNavigationManagerTest
 * @package Dynamic\CoreTools\Tests\Extensions
 */
class UtilityNavigationManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'core-tools/tests/Fixtures.yml';

    /**
     * @var array
     */
    public static $extra_data_objects = [
        UtilitySiteConfig::class,
    ];

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = Injector::inst()->create('UtilitySiteConfig');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('UtilityLinks'));

        $object->write();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('UtilityLinks'));
    }

}

/**
 * Class UtilitySiteConfig
 * @package Dynamic\CoreTools\Tests\Extensions
 */
class UtilitySiteConfig extends SiteConfig implements TestOnly
{
    private static $extensions = ['Dynamic\\CoreTools\\ORM\\UtilityNavigationManager'];
}