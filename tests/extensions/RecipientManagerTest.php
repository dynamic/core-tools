<?php

namespace Dynamic\CoreTools\Tests\Extensions;

use SilverStripe\Dev\SapphireTest;
use \Page;

/**
 * Class RecipientManagerTest
 * @package Dynamic\CoreTools\Tests\Extensions
 */
class RecipientManagerTest extends SapphireTest
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
        $object = $this->objFromFixture('\Page', 'default');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('Recipients'));
        $this->assertNotNull($fields->dataFieldByName('EmailSubject'));
        $this->assertNotNull($fields->dataFieldByName('ThankYouMessage'));
    }
}

Page::add_extension('Dynamic\\CoreTools\\ORM\\RecipientManager');