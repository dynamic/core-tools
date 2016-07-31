<?php

class ContentObjectTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        'core-tools/tests/Fixtures.yml',
    );

    public function testGetCMSFields()
    {
        $object = $this->objFromFixture('ContentObject', 'default');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('FieldList', $fields);
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

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canView($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canView($member));
    }

    public function testCanEdit()
    {
        $object = $this->objFromFixture('ContentObject', 'default');

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canEdit($member));
    }

    public function testCanDelete()
    {
        $object = $this->objFromFixture('ContentObject', 'default');

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canDelete($member));
    }

    public function testCanCreate()
    {
        $object = $this->objFromFixture('ContentObject', 'default');

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canCreate($member));
    }
}
