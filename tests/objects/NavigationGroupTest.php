<?php

namespace Dynamic\CoreTools\Tests\Model;

use SilverStripe\Dev\SapphireTest,
    SilverStripe\Core\Injector\Injector;

/**
 * Class NavigationGroupTest
 * @package Dynamic\CoreTools\Tests\Model
 */
class NavigationGroupTest extends SapphireTest
{

    /**
     * @var string
     */
    protected static $fixture_file = 'core-tools/tests/Fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = Injector::inst()->create('Dynamic\\CoreTools\\Model\\NavigationGroup');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('NavigationLinks'));

        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\NavigationGroup', 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('NavigationLinks'));
    }

    /**
     *
     */
    public function testValidateTitle()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\NavigationGroup', 'one');
        $object->Title = '';
        $this->setExpectedException('SilverStripe\\ORM\\ValidationException');
        $object->write();
    }

    /**
     *
     */
    public function testCanView()
    {
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\NavigationGroup', 'one');

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
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\NavigationGroup', 'one');

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
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\NavigationGroup', 'one');

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
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\NavigationGroup', 'one');

        $admin = $this->objFromFixture('SilverStripe\\Security\\Member', 'admin');
        $this->assertTrue($object->canCreate($admin));

        $member = $this->objFromFixture('SilverStripe\\Security\\Member', 'default');
        $this->assertTrue($object->canCreate($member));
    }

}
