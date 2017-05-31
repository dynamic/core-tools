<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\ORM\TagManager;
use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use SilverStripe\Core\Injector\Injector;
use \Page;
use SilverStripe\Dev\SapphireTest;

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

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('Tags'));

        $object = Injector::inst()->create(TestPage::class);
        $object->writeToStage('Stage');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('Tags'));
    }

}
