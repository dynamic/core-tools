<?php

class UtilityNavigationManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'core-tools/tests/Fixtures.yml';

    /**
     * @var array
     */
    protected $extraDataObjects = [
        'UtilitySiteConfig',
    ];

    public function testGetCMSFields()
    {
        $object = new UtilitySiteConfig();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
        $this->assertNull($fieldset->dataFieldByName('UtilityLinks'));

        $object->write();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
        $this->assertNotNull($fieldset->dataFieldByName('UtilityLinks'));
    }

}

class UtilitySiteConfig extends SiteConfig implements TestOnly
{
    private static $extensions = ['UtilityNavigationManager'];
}