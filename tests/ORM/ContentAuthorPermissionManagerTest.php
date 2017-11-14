<?php

namespace Dynamic\CoreTools\Tests\ORM;

use SilverStripe\Dev\SapphireTest;
use Dynamic\CoreTools\Tests\TestOnly\Object\TestContentAuthorObject;
use SilverStripe\Security\Member;

/**
 * Class ContentAuthorPermissionManagerTest.
 */
class ContentAuthorPermissionManagerTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        '../Fixtures.yml',
    );

    /**
     * @var array
     */
    public static $extra_data_objects = array(
        TestContentAuthorObject::class,
    );

    /**
     *
     */
    public function testCanView()
    {
        $object = new TestContentAuthorObject();

        $admin = $this->objFromFixture(
            Member::class,
            'admin'
        );
        $this->assertTrue($object->canView($admin));

        $member = $this->objFromFixture(
            Member::class,
            'default'
        );
        $this->assertTrue($object->canView($member));
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = new TestContentAuthorObject();

        $admin = $this->objFromFixture(
            Member::class,
            'admin'
        );
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture(
            Member::class,
            'default'
        );
        $this->assertTrue($object->canEdit($member));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = new TestContentAuthorObject();

        $admin = $this->objFromFixture(
            Member::class,
            'admin'
        );
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture(
            Member::class,
            'default'
        );
        $this->assertTrue($object->canDelete($member));
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = new TestContentAuthorObject();

        $admin = $this->objFromFixture(
            Member::class,
            'admin'
        );
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture(
            Member::class,
            'default'
        );
        $this->assertTrue($object->canCreate($member));
    }
}
