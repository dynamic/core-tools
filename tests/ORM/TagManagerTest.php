<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

/**
 * Class TagManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class TagManagerTest extends SapphireTest
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
        TestPage::class
    ];

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create(TestPage::class);
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNull($fields->dataFieldByName('Tags'));

        $object = Injector::inst()->create(TestPage::class);
        $object->writeToStage('Stage');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldByName('Tags'));
    }

}
