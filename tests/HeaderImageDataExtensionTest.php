<?php

class HeaderImageDataExtensionTest extends SapphireTest
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
        $extension = new HeaderImageDataExtension();
        $fields = $object->getCMSFields();
        $extension->updateCMSFields($fields);

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNotNull($fields->dataFieldByName('HeaderImage'));
    }

    public function testGetPageHeaderImage()
    {
        $page = $this->objFromFixture('Page', 'default');
        $subpage = $this->objFromFixture('Page', 'subpage');
        $image = $this->objFromFixture('Image', 'header');

        $this->assertNull($subpage->getPageHeaderImage());

        $page->HeaderImageID = $image->ID;
        $page->write();

        $this->assertInstanceOf('Image', $page->getPageHeaderImage());
        $this->assertInstanceOf('Image', $subpage->getPageHeaderImage());

        $subpage->HeaderImageID = $image->ID;
        $subpage->write();
        $this->assertInstanceOf('Image', $subpage->getPageHeaderImage());
    }
}

Page::add_extension('HeaderImageDataExtension');
