<?php

use SilverStripe\Dev\SapphireTest;

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
        $object = singleton('Page');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('ContentLinks'));

        $object = $this->objFromFixture('Page', 'default');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('ContentLinks'));
    }
}

Page::add_extension('MultiLinksManager');