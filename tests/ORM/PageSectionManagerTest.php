<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use Dynamic\CoreTools\ORM\PageSectionManager;
use \Page;

/**
 * Class PageSectionManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class PageSectionManagerTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        'core-tools/tests/Fixtures.yml',
    );

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        Page::add_extension(PageSectionManager::class);
    }

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
        $section = $this->objFromFixture(
            'Dynamic\\CoreTools\\Model\\PageSection',
            'default'
        );

        $this->assertEquals(0, $page->getPageSections()->count());

        $page->Sections()->add($section);
        $this->assertInstanceOf(
            'SilverStripe\\ORM\\DataList',
            $page->getPageSections()
        );
        $this->assertInstanceOf(
            'Dynamic\\CoreTools\\Model\\PageSection',
            $page->getPageSections()->first()
        );
    }

}
