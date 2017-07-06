<?php

namespace Dynamic\CoreTools\Tests\Model;

use Dynamic\CoreTools\Tests\CoreToolsTest;
use Dynamic\CoreTools\Model\Tag;
use SilverStripe\Security\Member;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\ValidationException;

/**
 * Class TagTest
 * @package Dynamic\CoreTools\Tests\Model
 */
class TagTest extends CoreToolsTest
{

    /**
     *
     */
    public function testValidateTitle()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\Tag', 'one');
        $object->Title = '';
        $this->setExpectedException(ValidationException::class);
        $object->write();
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\Tag', 'one');
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
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\Tag', 'one');
        $object->write();
        $objectID = $object->ID;
        $this->logInWithPermission('ADMIN');
        $originalTitle = $object->Title;
        $this->assertEquals($originalTitle, 'Tag One');
        $this->assertTrue($object->canEdit());
        $object->Title = 'Changed Title';
        $object->write();
        $testEdit = Tag::get()->byID($objectID);
        $this->assertEquals($testEdit->Title, 'Changed Title');
        $this->logOut();
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\Tag', 'one');
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
        $object = Injector::inst()->create('Dynamic\\CoreTools\\Model\\Tag');
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canCreate());
        $this->logOut();
        $nullMember = Member::create();
        $nullMember->write();
        $this->assertTrue($object->canCreate($nullMember));
        $nullMember->delete();
    }

}
