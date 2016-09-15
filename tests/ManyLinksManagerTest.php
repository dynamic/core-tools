<?php

class ManyLinksManagerTest extends SapphireTest
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
    public function testUpdateCMSFields()
    {
        $object = singleton('Page');
        $fields = $object->getCMSFields();

        $extension = new ManyLinksManager();
        $extension->updateCMSFields($fields);
        $this->assertInstanceOf('FieldList', $fields);

        $object = $this->objFromFixture('Page', 'default');
        $fields = $object->getCMSFields();

        $extension->updateCMSFields($fields);
        $this->assertInstanceOf('FieldList', $fields);
    }
}