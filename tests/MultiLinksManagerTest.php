<?php

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;

class MultiLinksManagerTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        'core-tools/tests/Fixtures.yml',
    );

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->get('\\Page');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('ContentLinks'));

        $object = $this->objFromFixture('\\Page', 'default');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('ContentLinks'));
    }
}

Page::add_extension('Dynamic\\CoreTools\\ORM\\MultiLinksManager');