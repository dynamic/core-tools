<?php

class PageSectionManagerTest extends CoreToolsTest
{
    public function testUpdateCMSFields()
    {
        $object = singleton('TestPage');
        $fields = $object->getCMSFields();

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNull($fields->dataFieldByName('Sections'));

        $object = $this->objFromFixture('TestPage', 'parent');
        $fields = $object->getCMSFields();

        $this->assertTrue(is_a($fields, 'FieldList'));
        $this->assertNotNull($fields->dataFieldByName('Sections'));
    }

    public function testGetPageSections()
    {
        $page = $this->objFromFixture('TestPage', 'parent');
        $section = $this->objFromFixture('PageSection', 'default');

        $this->assertTrue($page->getPageSections()->Count() == 0);

        $page->Sections()->add($section);
        $this->assertTrue($page->getPageSections()->Count() > 0);
        $this->assertInstanceOf('PageSection', $page->getPageSections()->First());
    }
}
