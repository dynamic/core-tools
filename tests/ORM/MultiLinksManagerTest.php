<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use Dynamic\CoreTools\ORM\MultiLinksManager;
use SilverStripe\Forms\FieldList;

/**
 * Class MultiLinksManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class MultiLinksManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = array(
        'core-tools/tests/CoreToolsTest.yml',
        'core-tools/tests/Fixtures.yml',
    );

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        TestPage::add_extension(MultiLinksManager::class);
    }

        /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->get(TestPage::class);
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNull($fields->dataFieldByName('ContentLinks'));

        $object = $this->objFromFixture(TestPage::class, 'default');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        //$this->assertNotNull($fields->dataFieldByName('ContentLinks'));
    }
}