<?php

class ContentObjectTest extends CoreToolsTest
{
    public function testGetCMSFields()
    {
        $object = new ContentObject();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
    }

    public function testValidateName()
    {
        $object = $this->objFromFixture('ContentObject', 'default');
        $object->Name = '';
        $this->setExpectedException('ValidationException');
        $object->write();
    }

    public function testCanView()
    {
        $object = $this->objFromFixture('ContentObject', 'default');
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
        $object = $this->objFromFixture('ContentObject', 'default');
        $object->write();
        $objectID = $object->ID;
        $this->logInWithPermission('ADMIN');
        $originalTitle = $object->Title;
        $this->assertEquals($originalTitle, 'First Content Object');
        $this->assertTrue($object->canEdit());
        $object->Title = 'Changed Title';
        $object->write();
        $testEdit = ContentObject::get()->byID($objectID);
        $this->assertEquals($testEdit->Title, 'Changed Title');
        $this->logOut();
    }

    public function testCanDelete()
    {
        $object = $this->objFromFixture('ContentObject', 'default');
        $object->write();
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canDelete());
        $checkObject = $object;
        $object->delete();
        $this->assertEquals($checkObject->ID, 0);
    }

    public function testCanCreate()
    {
        $object = singleton('ContentObject');
        $this->logInWithPermission('ADMIN');
        $this->assertTrue($object->canCreate());
        $this->logOut();
        $nullMember = Member::create();
        $nullMember->write();
        $this->assertTrue($object->canCreate($nullMember));
        $nullMember->delete();
    }
}
