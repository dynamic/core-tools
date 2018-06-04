<?php

namespace Dynamic\CoreTools\Tests\Model;

use Dynamic\CoreTools\Model\ContentObject;
use Dynamic\CoreTools\Tests\TestOnly\Controller\TestPageController;
use Dynamic\CoreTools\Tests\TestOnly\Page\TestPage;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Security\Member;

/**
 * Class ContentObjectTest.
 */
class ContentObjectTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $extra_dataobjects = array(
        TestPage::class,
        TestPageController::class,
    );

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
        $object = $this->objFromFixture(ContentObject::class, 'default');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
    }

    /**
     *
     */
    public function testValidateName()
    {
        //$this->markTestSkipped('Skipped');
        $object = $this->objFromFixture(ContentObject::class, 'default');
        $object->Title = '';
        $this->setExpectedException(ValidationException::class);
        $object->write();
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture(ContentObject::class, 'default');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canView($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertTrue($object->canView($member));
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = $this->objFromFixture(ContentObject::class, 'default');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertTrue($object->canEdit($member));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture(ContentObject::class, 'default');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertTrue($object->canDelete($member));
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = $this->objFromFixture(ContentObject::class, 'default');

        $admin = $this->objFromFixture(Member::class, 'admin');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture(Member::class, 'default');
        $this->assertTrue($object->canCreate($member));
    }
}
