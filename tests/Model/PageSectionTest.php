<?php

namespace Dynamic\CoreTools\Tests\Model;

use Dynamic\CoreTools\Model\PageSection;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Security\Member;

/**
 * Class PageSectionTest.
 */
class PageSectionTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        '../Fixtures.yml',
    );

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = $this->objFromFixture(PageSection::class, 'default');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture(PageSection::class, 'default');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canView($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canView($member));
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = $this->objFromFixture(PageSection::class, 'default');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canEdit($member));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture(PageSection::class, 'default');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canDelete($member));
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = Injector::inst()->create(PageSection::class);

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertFalse($object->canCreate($member));
    }

    /**
     *
     */
    public function testProvidePermissions()
    {
        $object = Injector::inst()->create(PageSection::class);
        $expected = array(
            'PageSection_EDIT' => 'Page Section Edit',
            'PageSection_DELETE' => 'Page Section Delete',
            'PageSection_CREATE' => 'Page Section Create',
            'PageSection_VIEW' => 'Page Section View',
        );
        $this->assertEquals($expected, $object->providePermissions());
    }
}
