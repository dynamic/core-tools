<?php

namespace Dynamic\CoreTools\Tests\Model;

use Dynamic\CoreTools\Model\CoreTag;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\IdentityStore;
use SilverStripe\Security\Member;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\ValidationException;

/**
 * Class CoreTagTest.
 */
class CoreTagTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = array(
        '../CoreToolsTest.yml',
        '../Fixtures.yml',
    );

    /**
     * Log out the current user.
     */
    public function logOut()
    {
        /** @var IdentityStore $store */
        $store = Injector::inst()->get(IdentityStore::class);
        $store->logOut();
    }

    /**
     *
     */
    public function testValidateTitle()
    {
        $object = $this->objFromFixture(CoreTag::class, 'one');
        $object->Title = '';
        $this->setExpectedException(ValidationException::class);
        $object->write();
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture(CoreTag::class, 'one');
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canView());
        $this->logOut();

        $nullMember = Member::create();
        $nullMember->write();
        $this->assertTrue($object->canView($nullMember));
        $nullMember->delete();
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = $this->objFromFixture(CoreTag::class, 'one');
        $object->write();
        $objectID = $object->ID;
        $this->logInWithPermission('ADMIN');
        $originalTitle = $object->Title;
        $this->assertEquals($originalTitle, 'Tag One');
        $this->assertTrue($object->canEdit());
        $object->Title = 'Changed Title';
        $object->write();
        $testEdit = CoreTag::get()->byID($objectID);
        $this->assertEquals($testEdit->Title, 'Changed Title');
        $this->logOut();
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture(CoreTag::class, 'one');
        $object->write();
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canDelete());
        $checkObject = $object;
        $object->delete();
        $this->assertEquals($checkObject->ID, 0);
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = Injector::inst()->create(CoreTag::class);
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canCreate());
        $this->logOut();
        $nullMember = Member::create();
        $nullMember->write();
        $this->assertTrue($object->canCreate($nullMember));
        $nullMember->delete();
    }
}
