<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest,
    SilverStripe\Core\Injector\Injector,
    \Page;

/**
 * Class PageSectionManagerTest
 * @package Dynamic\CoreTools\Tests\Extensions
 */
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
        $object = Injector::inst()->create('\Page');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('Sections'));

        $object = $this->objFromFixture('\Page', 'default');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('Sections'));
    }

    public function testGetPageSections()
    {
        $page = $this->objFromFixture('\Page', 'default');
        $section = $this->objFromFixture('Dynamic\\CoreTools\\Model\\PageSection', 'default');

        $this->assertEquals(0, $page->getPageSections()->count());

        $page->Sections()->add($section);
        $this->assertInstanceOf('SilverStripe\\ORM\\DataList', $page->getPageSections());
        $this->assertInstanceOf('Dynamic\\CoreTools\\Model\\PageSection', $page->getPageSections()->First());
    }

}

Page::add_extension('Dynamic\\CoreTools\\Extensions\\PageSectionManager');
Page::add_extension('Dynamic\\CoreTools\\Extensions\\PageSectionRelation');