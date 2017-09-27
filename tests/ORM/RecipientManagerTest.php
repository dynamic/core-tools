<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use SilverStripe\Dev\SapphireTest;
use Dynamic\CoreTools\ORM\RecipientManager;
use SilverStripe\Forms\FieldList;

/**
 * Class RecipientManagerTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class RecipientManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = array(
        '../CoreToolsTest.yml',
        '../Fixtures.yml',
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
    public function setUp()
    {
        parent::setUp();

        TestPage::add_extension(RecipientManager::class);
    }

    /**
     *
     */
    public function testUpdateCMSFields()
    {
        $object = $this->objFromFixture(TestPage::class, 'default');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNotNull($fields->dataFieldByName('Recipients'));
        $this->assertNotNull($fields->dataFieldByName('EmailSubject'));
        $this->assertNotNull($fields->dataFieldByName('ThankYouMessage'));
    }
}