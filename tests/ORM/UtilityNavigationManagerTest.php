<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use Dynamic\CoreTools\Tests\TestOnly\UtilitySiteConfig;
use SilverStripe\Forms\FieldList;

/**
 * Class UtilityNavigationManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class UtilityNavigationManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'tests/Fixtures.yml';

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
            ->create(UtilitySiteConfig::class);
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNull($fields->dataFieldByName('UtilityLinks'));

        $object->write();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldByName('UtilityLinks'));
    }

}