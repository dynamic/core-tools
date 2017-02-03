<?php

class CoreTagTest extends CoreToolsTest
{
    public function testValidateTitle()
    {
        $object = $this->objFromFixture('CoreTag', 'one');
        $object->Title = '';
        $this->setExpectedException('ValidationException');
        $object->write();
    }

    public function testCanView()
    {
        $object = $this->objFromFixture('CoreTag', 'one');
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canView());
        $this->logOut();

        $nullMember = Member::create();
        $nullMember->write();
        $this->assertTrue($object->canView($nullMember));
        $nullMember->delete();
    }

    public function testCanEdit()
    {
        $object = $this->objFromFixture('CoreTag', 'one');
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

    public function testCanDelete()
    {
        $object = $this->objFromFixture('CoreTag', 'one');
        $object->write();
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canDelete());
        $checkObject = $object;
        $object->delete();
        $this->assertEquals($checkObject->ID, 0);
    }

    public function testCanCreate()
    {
        $object = singleton('CoreTag');
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canCreate());
        $this->logOut();
        $nullMember = Member::create();
        $nullMember->write();
        $this->assertTrue($object->canCreate($nullMember));
        $nullMember->delete();
    }
}
