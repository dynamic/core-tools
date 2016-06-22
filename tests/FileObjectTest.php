<?php

class FileObjectTest extends CoreToolsTest
{
    public function testGetCMSFields()
    {
        $object = new FileObject();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
    }
}
