<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\Tests\CoreToolsTest;
use SilverStripe\Core\Injector\Injector;

/**
 * Class TagManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class TagManagerTest extends CoreToolsTest
{

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create('TestPage');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('Tags'));

        $object = $this->objFromFixture('TestPage', 'parent');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('Tags'));
    }

}
