<?php

class PageSectionTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        'core-tools/tests/Fixtures.yml',
    );

    public function testGetCMSFields()
    {
        $object = $this->objFromFixture('PageSection', 'default');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('FieldList', $fields);
    }

    public function testCanView()
    {
        $object = $this->objFromFixture('PageSection', 'default');

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canView($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertFalse($object->canView($member));
    }

    public function testCanEdit()
    {
        $object = $this->objFromFixture('PageSection', 'default');

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertFalse($object->canEdit($member));
    }

    public function testCanDelete()
    {
        $object = $this->objFromFixture('PageSection', 'default');

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertFalse($object->canDelete($member));
    }

    public function testCanCreate()
    {
        $object = singleton('PageSection');

        $admin = $this->objFromFixture('Member', 'admin');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture('Member', 'default');
        $this->assertFalse($object->canCreate($member));
    }

    public function testProvidePermissions()
    {
        $object = singleton('PageSection');
        $expected = array(
            'PageSection_EDIT' => 'Page Section Edit',
            'PageSection_DELETE' => 'Page Section Delete',
            'PageSection_CREATE' => 'Page Section Create',
            'PageSection_VIEW' => 'Page Section View',
        );
        $this->assertEquals($expected, $object->providePermissions());
    }
}
