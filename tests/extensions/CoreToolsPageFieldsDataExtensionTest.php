<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;

/**
 * Class CoreToolsPageFieldsDataExtensionTest
 * @package Dynamic\CoreTools\Tests\Extensions
 */
class CoreToolsPageFieldsDataExtensionTest extends SapphireTest
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
        $object = Injector::inst()->create('Dynamic\\CoreTools\\Tests\\TestPage');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('SubTitle'));
        $this->assertNotNull($fields->dataFieldByName('PageTitle'));
    }

}
