<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use Dynamic\CoreTools\Tests\TestOnly\Object\FooterSiteConfig;
use SilverStripe\Forms\FieldList;

/**
 * Class FooterNavigationManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class FooterNavigationManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'Fixtures.yml';

    /**
     * @var array
     */
    public static $extra_data_objects = [
        FooterSiteConfig::class,
    ];

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = Injector::inst()->create(FooterSiteConfig::class);
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNull($fields->dataFieldByName('NavigationColumns'));

        $object->write();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldByName('NavigationColumns'));
    }
}

