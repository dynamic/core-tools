<?php

namespace Dynamic\CoreTools\Tests\Model;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\Assets\File;

/**
 * Class FileObjectTest
 * @package Dynamic\CoreTools\Tests\Model
 */
class FileObjectTest extends SapphireTest
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
        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\FileObject', 'default');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf('SilverStripe\\Forms\\FieldList', $fields);
    }

    /**
     * Test {@link FileObject::getFileLinkURL()} returns proper value
     */
    public function testFileLinkURL()
    {

        $file = File::create();
        $file->FileName = 'path/to/file.pdf';
        $file->write();

        $object = $this->objFromFixture('Dynamic\\CoreTools\\Model\\FileObject', 'default');
        $object->DownloadID = $file->ID;
        $object->write();

        $this->assertEquals($object->getFileLinkURL(), 'path/to/file.pdf');

        $object->DownloadID = 0;
        $object->FileLink = 'http://somedomain.com/file.pdf';
        $object->write();

        $this->assertEquals($object->getFileLinkURL(), 'http://somedomain.com/file.pdf');

    }

}
