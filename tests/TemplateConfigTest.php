<?php

class TemplateConfigTest extends SapphireTest
{
    /**
     * @var array
     */
    protected static $fixture_file = array(
        'core-tools/tests/Fixtures.yml',
    );

    public function testUpdateCMSFields()
    {
        $object = GlobalSiteSetting::current_global_config();
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('TitleLogo'));
    }

    public function testGetSiteLogo()
    {
        $object = GlobalSiteSetting::current_global_config();
        $logo = $this->objFromFixture('Image', 'logo');
        $object->LogoID = $logo->ID;
        $this->assertInstanceOf('Image', $object->getSiteLogo());
    }
}

Object::add_extension('GlobalSiteSetting', 'TemplateConfig');