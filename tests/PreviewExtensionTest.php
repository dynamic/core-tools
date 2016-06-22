<?php

class PreviewExtensionTest extends CoreToolsTest
{
    public function testUpdateCMSFields()
    {
        $object = $this->objFromFixture('TestPage', 'parent');
        $fields = $object->getCMSFields();

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNotNull($fields->dataFieldByName('PreviewTitle'));
        $this->assertNotNull($fields->dataFieldByName('Abstract'));
        $this->assertNotNull($fields->dataFieldByName('PreviewImage'));
    }

    public function testGetPreviewHeadline()
    {
        $object = $this->objFromFixture('TestPage', 'parent');
        $this->assertEquals($object->getPreviewHeadline(), $object->Title);

        $object->PreviewTitle = 'Preview';
        $this->assertEquals($object->getPreviewHeadline(), $object->PreviewTitle);
    }

    public function testGetPreviewThumb()
    {
        $object = $this->objFromFixture('TestPage', 'parent');
        $image = $this->objFromFixture('Image', 'preview');
        $this->assertFalse($object->getPreviewThumb());

        $object->PreviewImageID = $image->ID;
        $this->assertInstanceOf('Image', $object->getPreviewThumb());
    }

    public function testGetPreviewAbstract()
    {
        $object = $this->objFromFixture('TestPage', 'parent');
        $this->assertEquals($object->getPreviewAbstract(), $object->obj('Content')->FirstParagraph());

        $object->Abstract = 'Preview';
        $this->assertEquals($object->getPreviewAbstract(), $object->Abstract);
    }
}
