<?php

/**
 * Class CoreFormFieldExtensionTest
 */
class CoreFormFieldExtensionTest extends SapphireTest
{

    /**
     * @var array
     */
    private static $extra_dataobjects = array(
        CoreFormFieldExtensionTest_Object::class,
    );

    /**
     * Tests updateCMSFields
     */
    public function testGetCMSFields()
    {
        /** @var CoreFormFieldExtensionTest_Object $obj */
        $obj = Injector::inst()->create(CoreFormFieldExtensionTest_Object::class);
        $fields = $obj->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
