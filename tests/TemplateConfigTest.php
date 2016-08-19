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
        $object = singleton('SiteConfig');
        $fields = $object->getCMSFields();

        $this->assertInstanceOf('FieldList', $fields);
        $this->assertNotNull($fields->dataFieldByName('TitleLogo'));
    }

    public function testGetSiteLogo()
    {
        $object = singleton('SiteConfig');
        $logo = $this->objFromFixture('Image', 'logo');
        $object->LogoID = $logo->ID;
        $this->assertInstanceOf('Image', $object->getSiteLogo());
    }
}

SiteConfig::add_extension('TemplateConfig');