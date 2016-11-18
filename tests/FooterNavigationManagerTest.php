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
        'FooterSiteConfig',
    ];

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = new FooterSiteConfig();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNull($fields->dataFieldByName('NavigationColumns'));

        $object->write();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('NavigationColumns'));
    }
}

class FooterSiteConfig extends SiteConfig implements TestOnly
{
    private static $extensions = ['FooterNavigationManager'];
}
