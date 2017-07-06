<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use Dynamic\CoreTools\Tests\TestOnly\UtilitySiteConfig;

/**
 * Class UtilityNavigationManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
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
        $object = Injector::inst()
            ->create('Dynamic\\CoreTools\\Tests\\TestOnly\\UtilitySiteConfig');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('UtilityLinks'));

        $object->write();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('UtilityLinks'));
    }

}