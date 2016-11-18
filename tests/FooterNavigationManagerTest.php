<?php

class FooterNavigationManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'core-tools/tests/Fixtures.yml';

    /**
     * @var array
     */
    protected $extraDataObjects = [
        'TestSiteConfig',
    ];

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = new TestSiteConfig();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('NavigationColumns'));

        $object->write();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('NavigationColumns'));
    }
}

class TestSiteConfig extends SiteConfig implements TestOnly
{
    private static $extensions = ['FooterNavigationManager'];
}
