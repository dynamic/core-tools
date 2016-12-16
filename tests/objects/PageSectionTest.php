<?php

namespace Dynamic\CoreTools\Tests\Model;

use SilverStripe\Dev\SapphireTest,
    SilverStripe\Core\Injector\Injector;

/**
 * Class PageSectionTest
 * @package Dynamic\CoreTools\Tests\Model
 */
class PageSectionTest extends SapphireTest
{

    /**
     * @var array
     */
    protected static $fixture_file = array(
        'core-tools/tests/Fixtures.yml',
    );

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\PageSection', 'default');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\PageSection', 'default');

        $admin = $this->objFromFixture('SilverStripe\\Security\\Member', 'admin');
        $this->assertTrue($object->canView($admin));

        $member = $this->objFromFixture('SilverStripe\\Security\\Member', 'default');
        $this->assertFalse($object->canView($member));
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\PageSection', 'default');

        $admin = $this->objFromFixture('SilverStripe\\Security\\Member', 'admin');
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture('SilverStripe\\Security\\Member', 'default');
        $this->assertFalse($object->canEdit($member));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\PageSection', 'default');

        $admin = $this->objFromFixture('SilverStripe\\Security\\Member', 'admin');
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture('SilverStripe\\Security\\Member', 'default');
        $this->assertFalse($object->canDelete($member));
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = Injector::inst()->create('PageSection');

        $admin = $this->objFromFixture('SilverStripe\\Security\\Member', 'admin');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture('SilverStripe\\Security\\Member', 'default');
        $this->assertFalse($object->canCreate($member));
    }

    /**
     *
     */
    public function testProvidePermissions()
    {
        $object = Injector::inst()->create('PageSection');
        $expected = array(
            'PageSection_EDIT' => 'Page Section Edit',
            'PageSection_DELETE' => 'Page Section Delete',
            'PageSection_CREATE' => 'Page Section Create',
            'PageSection_VIEW' => 'Page Section View',
        );
        $this->assertEquals($expected, $object->providePermissions());
    }

}
