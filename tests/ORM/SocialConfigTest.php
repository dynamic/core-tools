<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\Model\GlobalSiteSetting;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

/**
 * Class SocialConfigTest.
 */
class SocialConfigTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../Fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = $this->objFromFixture(GlobalSiteSetting::class, 'settings');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }
}
