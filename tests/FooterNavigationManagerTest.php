<?php

class FooterNavigationManagerTest extends SapphireTest
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
        $object = GlobalSiteSetting::current_global_config();
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('NavigationColumns'));
    }
}