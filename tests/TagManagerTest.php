<?php

class TagManagerTest extends CoreToolsTest
{
    public function testUpdateCMSFields()
    {
        $object = singleton('TestPage');
        $fields = $object->getCMSFields();

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNull($fields->dataFieldByName('Tags'));

        $object = $this->objFromFixture('TestPage', 'parent');
        $fields = $object->getCMSFields();

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNotNull($fields->dataFieldByName('Tags'));
    }
}