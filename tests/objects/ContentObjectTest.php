<?php

namespace Dynamic\CoreTools\Tests\Model;

use SilverStripe\Dev\SapphireTest;

/**
 * Class ContentObjectTest
 * @package Dynamic\CoreTools\Tests\Model
 */
class ContentObjectTest extends SapphireTest
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
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\ContentObject', 'default');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
    }

    /**
     *
     */
    public function testValidateName()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\ContentObject', 'default');
        $object->Name = '';
        $this->setExpectedException('SilverStripe\\\ORM\\ValidationException');
        $object->write();
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\ContentObject', 'default');

        $admin = $this->objFromFixture('SilverStripe\\Security\\Member', 'admin');
        $this->assertTrue($object->canView($admin));

        $member = $this->objFromFixture('SilverStripe\\Security\\Member', 'default');
        $this->assertTrue($object->canView($member));
    }

    /**
     *
     */
    public function testCanEdit()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\ContentObject', 'default');

        $admin = $this->objFromFixture('SilverStripe\\Security\\Member', 'admin');
        $this->assertTrue($object->canEdit($admin));

        $member = $this->objFromFixture('SilverStripe\\Security\\Member', 'default');
        $this->assertTrue($object->canEdit($member));
    }

    /**
     *
     */
    public function testCanDelete()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\ContentObject', 'default');

        $admin = $this->objFromFixture('SilverStripe\\Security\\Member', 'admin');
        $this->assertTrue($object->canDelete($admin));

        $member = $this->objFromFixture('SilverStripe\\Security\\Member', 'default');
        $this->assertTrue($object->canDelete($member));
    }

    /**
     *
     */
    public function testCanCreate()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\ContentObject', 'default');

        $admin = $this->objFromFixture('SilverStripe\\Security\\Member', 'admin');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture('SilverStripe\\Security\\Member', 'default');
        $this->assertTrue($object->canCreate($member));
    }

}
