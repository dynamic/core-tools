<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use Dynamic\CoreTools\ORM\RecipientManager;
use \Page;

/**
 * Class RecipientManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
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
    public function setUp()
    {
        parent::setUp();

        Page::add_extension(RecipientManager::class);
    }

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