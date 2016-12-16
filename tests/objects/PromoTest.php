<?php

namespace Dynamic\CoreTools\Tests\Model;

use Dynamic\CoreTools\Tests\CoreToolsTest,
    Dynamic\CoreTools\Model\Promo,
    SilverStripe\Core\Injector\Injector,
    SilverStripe\Security\Member;

/**
 * Class PromoTest
 * @package Dynamic\CoreTools\Tests\Model
 */
class PromoTest extends CoreToolsTest
{

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = Injector::inst()->create('Dynamic\\CoreTools\\Model\\Promo');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\Promo', 'default');
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
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\Promo', 'default');
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
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\Promo', 'default');
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
        $object = Injector::inst()->create('Dynamic\\CoreTools\\Model\\Promo');
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
        $object = Injector::inst()->create('Dynamic\\CoreTools\\Model\\Promo');
        $expected = array(
            'Promo_EDIT' => 'Promo Edit',
            'Promo_DELETE' => 'Promo Delete',
            'Promo_CREATE' => 'Promo Create',
        );
        $this->assertEquals($expected, $object->providePermissions());
    }

}
