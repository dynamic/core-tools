<?php

class CoreToolsPageFIeldsDataExtensionTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        'core-tools/tests/Fixtures.yml',
    );

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
