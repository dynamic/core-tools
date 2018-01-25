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

    /**
     * Tests afterUpdateFormField()
     */
    public function testAfterUpdateFormField()
    {
        /** @var FormField $field */
        $field = Injector::inst()->createWithArgs(FormField::class, ['test']);
        /** @var CoreFormFieldExtensionTest_Object $obj */
        $obj = Injector::inst()->create(CoreFormFieldExtensionTest_Object::class);
        $obj->FieldWidth = 'full';

        $this->assertNotContains('full', $field->extraClass());

        $obj->afterUpdateFormField($field);
        $this->assertContains('full', $field->extraClass());
    }
}
