<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\ORM\ManyLinksManager;
use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FieldList;

/**
 * Class ManyLinksManagerTest.
 */
class ManyLinksManagerTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        '../Fixtures.yml',
    );

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        TestPage::add_extension(ManyLinksManager::class);
    }

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create(TestPage::class);
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
