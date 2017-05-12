<?php

class UtilityNavigationManagerTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = 'core-tools/tests/Fixtures.yml';

    public function testGetCMSFields()
    {
        $object = GlobalSiteSetting::current_global_config();
        $fieldset = $object->getCMSFields();
        $this->assertTrue(is_a($fieldset, 'FieldList'));
        $this->assertNotNull($fieldset->dataFieldByName('UtilityLinks'));
    }

}