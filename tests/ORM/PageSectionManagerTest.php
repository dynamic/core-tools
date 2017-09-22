<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\Model\PageSection;
use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use Dynamic\CoreTools\ORM\PageSectionManager;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataList;

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

        TestPage::add_extension(PageSectionManager::class);
    }

    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create(TestPage::class);
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNull($fields->dataFieldByName('Sections'));

        $object = Injector::inst()->create(TestPage::class);
        $object->writeToStage('Stage');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldByName('Sections'));
    }

    public function testGetPageSections()
    {
        $page = Injector::inst()->create(TestPage::class);
        $page->writeToStage('Stage');
        $section = $this->objFromFixture(
            PageSection::class,
            'default'
        );

        $this->assertEquals(0, $page->getPageSections()->count());

        $page->Sections()->add($section);
        $this->assertInstanceOf(
            DataList::class,
            $page->getPageSections()
        );
        $this->assertInstanceOf(
            PageSection::class,
            $page->getPageSections()->first()
        );
    }

}
