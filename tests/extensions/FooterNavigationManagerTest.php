<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest,
    SilverStripe\Siteconfig\SiteConfig,
    SilverStripe\Dev\TestOnly,
    SilverStripe\Core\Injector\Injector;

/**
 * Class FooterNavigationManagerTest
 * @package Dynamic\CoreTools\Tests\Extensions
 */
class FooterNavigationManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'core-tools/tests/Fixtures.yml';

    /**
     * @var array
     */
    protected $extraDataObjects = [
        'Dynamic\\CoreTools\\Tests\\Extensions\\FooterSiteConfig',
    ];

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = Injector::inst()->create('FooterSiteConfig');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('NavigationColumns'));

        $object->write();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('NavigationColumns'));
    }
}

/**
 * Class FooterSiteConfig
 * @package Dynamic\CoreTools\Tests\Extensions
 */
class FooterSiteConfig extends SiteConfig implements TestOnly
{
    private static $extensions = ['Dynamic\\CoreTools\\Extensions\\FooterNavigationManager'];
}
