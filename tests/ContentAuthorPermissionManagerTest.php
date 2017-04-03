<?php

namespace Dynamic\CoreTools\Tests;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\ORM\DataObject;
use SilverStripe\Dev\TestOnly;

class ContentAuthorPermissionManagerTest extends SapphireTest
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
    protected $extraDataObjects = array(
        'TestContentAuthorObject',
    );

    /**
     *
     */
    public function testCanView()
    {
        $object = new TestContentAuthorObject();

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canView($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canView($member));
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = new TestContentAuthorObject();

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canEdit($member));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = new TestContentAuthorObject();

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canDelete($member));
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = new TestContentAuthorObject();

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canCreate($member));
    }
}

/**
 * Class TestContentAuthorObject.
 */
class TestContentAuthorObject extends DataObject implements TestOnly
{
    private static $extensions = [
        'ContentAuthorPermissionManager',
    ];
}
