<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest,
    SilverStripe\Core\Injector\Injector;

/**
 * Class ManyLinksManagerTest
 * @package Dynamic\CoreTools\Tests\Extensions
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