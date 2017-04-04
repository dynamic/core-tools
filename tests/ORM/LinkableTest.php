<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use Dynamic\CoreTools\ORM\Linkable;
use \Page;

/**
 * Class LinkableTest
 * @package Dynamic\CoreTools\Tests\ORM
 */
class LinkableTest extends SapphireTest
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

        Page::add_extension(Linkable::class);
    }

        /**
     *
     */
    public function testGetLinkStatus()
    {
        $page = $this->objFromFixture('\\Page', 'default');
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\ContentObject', 'default');
        $object->LinkType = 'Internal';
        $object->PageLinkID = $page->ID;
        $this->assertEquals($object->getLinkStatus(), 'internal');

        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\ContentObject', 'default');
        $object->LinkType = 'External';
        $object->ExternalLink = 'http://www.dynamicagency.com';
        $this->assertEquals($object->getLinkStatus(), 'external');
    }

    /**
     *
     */
    public function testLinkStatus()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\ContentObject', 'default');
        $this->assertEquals($object->LinkStatus(), $object->getLinkStatus());
    }

}
