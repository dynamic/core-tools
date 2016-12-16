<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use Dynamic\CoreTools\Tests\CoreToolsTest,
    SilverStripe\Core\Injector\Injector;

/**
 * Class TagManagerTest
 * @package Dynamic\CoreTools\Tests\Extensions
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
