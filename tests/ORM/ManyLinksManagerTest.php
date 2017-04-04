<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;

/**
 * Class ManyLinksManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class ManyLinksManagerTest extends SapphireTest
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
    public function testUpdateCMSFields()
    {
        $object = Injector::inst()->create('\Page');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
    }
}