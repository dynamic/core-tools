<?php

namespace Dynamic\CoreTools\Tests\ORM;

use Dynamic\CoreTools\Model\ContentObject;
use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use SilverStripe\Dev\SapphireTest;
use Dynamic\CoreTools\ORM\Linkable;

/**
 * Class LinkableTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class LinkableTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = array(
        'tests/CoreToolsTest.yml',
        'tests/Fixtures.yml',
    );

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        TestPage::add_extension(Linkable::class);
    }

        /**
     *
     */
    public function testGetLinkStatus()
    {
        $page = $this->objFromFixture(TestPage::class, 'default');
        $object = $this->objFromFixture(ContentObject::class, 'default');
        $object->LinkType = 'Internal';
        $object->PageLinkID = $page->ID;
        $this->assertEquals($object->getLinkStatus(), 'internal');

        $object = $this->objFromFixture(ContentObject::class, 'default');
        $object->LinkType = 'External';
        $object->ExternalLink = 'http://www.dynamicagency.com';
        $this->assertEquals($object->getLinkStatus(), 'external');
    }

    /**
     *
     */
    public function testLinkStatus()
    {
        $object = $this->objFromFixture(ContentObject::class, 'default');
        $this->assertEquals($object->LinkStatus(), $object->getLinkStatus());
    }

}
