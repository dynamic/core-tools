<?php

namespace Dynamic\CoreTools\Tests\Model;

use Dynamic\CoreTools\Model\Promo;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Security\IdentityStore;
use SilverStripe\Security\Member;

/**
 * Class PromoTest
 * @package Dynamic\CoreTools\Tests\Model
 */
class PromoTest extends SapphireTest
{

    /**
     * @var string
     */
    protected static $fixture_file = array(
        '../CoreToolsTest.yml',
        '../Fixtures.yml',
    );

    /**
     * Log out the current user
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
    public function testGetCMSFields()
    {
        $object = Injector::inst()->create(Promo::class);
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture(Promo::class, 'default');
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
        $object = $this->objFromFixture(Promo::class, 'default');
        $object->write();
        $objectID = $object->ID;
        $this->logInWithPermission('ADMIN');
        $originalTitle = $object->Title;
        $this->assertEquals($originalTitle, 'First Promo');
        $this->assertTrue($object->canEdit());
        $object->Title = 'Changed Title';
        $object->write();
        $testEdit = Promo::get()->byID($objectID);
        $this->assertEquals($testEdit->Title, 'Changed Title');
        $this->logOut();
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture(Promo::class, 'default');
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
        $object = Injector::inst()->create(Promo::class);
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canCreate());
        $this->logOut();
        $nullMember = Member::create();
        $nullMember->write();
        $this->assertFalse($object->canCreate($nullMember));
        $nullMember->delete();
    }

    /**
     *
     */
    public function testProvidePermissions()
    {
        $object = Injector::inst()->create(Promo::class);
        $expected = array(
            'Promo_EDIT' => 'Promo Edit',
            'Promo_DELETE' => 'Promo Delete',
            'Promo_CREATE' => 'Promo Create',
        );
        $this->assertEquals($expected, $object->providePermissions());
    }

}
