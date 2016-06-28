<?php

class CoreToolsPageFieldsDataExtensionTest extends CoreToolsTest
{
    public function testUpdateCMSFields()
    {
        $object = singleton('TestPage');
        $extension = new CoreToolsPageFieldsDataExtension();
        $fields = $object->getCMSFields();
        $extension->updateCMSFields($fields);

        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('SubTitle'));
        $this->assertNotNull($fields->dataFieldByName('PageTitle'));
    }
}