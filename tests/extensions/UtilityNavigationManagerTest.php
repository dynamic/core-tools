<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest,
    SilverStripe\Core\Injector\Injector,
    SilverStripe\SiteConfig\SiteConfig,
    SilverStripe\Dev\TestOnly;

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
    protected $extraDataObjects = [
        'Dynamic\\CoreTools\\Tests\\Extensions\\UtilitySiteConfig',
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
    private static $extensions = ['Dynamic\\CoreTools\\Extensions\\UtilityNavigationManager'];
}