<?php

class PageSectionManagerTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        'core-tools/tests/Fixtures.yml',
    );

    public function testUpdateCMSFields()
    {
        $object = new Page();
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('Sections'));

        $object = $this->objFromFixture('Page', 'default');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('Sections'));
    }

    public function testGetPageSections()
    {
        $page = $this->objFromFixture('Page', 'default');
        $section = $this->objFromFixture('PageSection', 'default');

        $this->assertTrue($page->getPageSections()->Count() == 0);

        $page->Sections()->add($section);
        $this->assertInstanceOf('DataList', $page->getPageSections());
        $this->assertInstanceOf('PageSection', $page->getPageSections()->First());
    }
}

Page::add_extension('PageSectionManager');
Page::add_extension('PageSectionRelation');
