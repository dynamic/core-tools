<?php

class NavigationGroupTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'core-tools/tests/Fixtures.yml';

    public function testGetCMSFields()
    {
        $object = singleton('NavigationGroup');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('NavigationLinks'));

        $object = $this->objFromFixture('NavigationGroup', 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('NavigationLinks'));
    }

    public function testValidateTitle()
    {
        $object = $this->objFromFixture('NavigationGroup', 'one');
        $object->Title = '';
        $this->setExpectedException('ValidationException');
        $object->write();
    }

    public function testCanView()
    {
        $object = $this->objFromFixture('NavigationGroup', 'one');

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canView($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canView($member));
    }

    public function testCanEdit()
    {
        $object = $this->objFromFixture('NavigationGroup', 'one');

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canEdit($member));
    }

    public function testCanDelete()
    {
        $object = $this->objFromFixture('NavigationGroup', 'one');

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canDelete($member));
    }

    public function testCanCreate()
    {
        $object = $this->objFromFixture('NavigationGroup', 'one');

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertTrue($object->canCreate($member));
    }
}
