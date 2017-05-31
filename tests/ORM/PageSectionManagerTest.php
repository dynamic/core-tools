<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
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
     * @var array
     */
    protected static $extra_dataobjects = [
        TestPage::class,
    ];

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
        $object = Injector::inst()->create(TestPage::class);
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('Sections'));

        $object = Injector::inst()->create(TestPage::class);
        $object->writeToStage('Stage');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('Sections'));
    }

    public function testGetPageSections()
    {
        $page = Injector::inst()->create(TestPage::class);
        $page->writeToStage('Stage');
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
