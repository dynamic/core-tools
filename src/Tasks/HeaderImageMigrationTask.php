<?php

namespace Dynamic\CoreTools\Tasks;

use Dynamic\CoreTools\Model\HeaderImage;
use Dynamic\CoreTools\ORM\HeaderImageDataExtension;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

/**
 * Class HeaderImageMigrationTask
 * @package Dynamic\CoreTools\Tasks
 */
class HeaderImageMigrationTask extends BuildTask
{
    /**
     * @var string
     */
    protected $title = 'Core Tools - Header Image Migration Task';

    /**
     * @var string
     */
    private static $segment = 'core-tools-header-image-migration-task';

    /**
     * @var
     */
    private $migration_list = [];

    /**
     * @param HTTPRequest $request
     */
    public function run($request)
    {
        $this->setMigrationList();
        $this->migrateHeaderImage();
    }

    /**
     * Set the classes that we should query for migration. We only migrate classes with the proper extension.
     * @return $this
     */
    protected function setMigrationList()
    {
        $migrationList = [];

        foreach ($this->getClassList() as $class) {
            if ($class::has_extension(HeaderImageDataExtension::class)) {
                $migrationList[] = $class;
            }
        }

        $this->migration_list = $migrationList;

        return $this;
    }

    /**
     * @return \Generator
     */
    protected function getClassList()
    {
        $classes = ClassInfo::subclassesFor(DataObject::class);

        unset($classes[strtolower(DataObject::class)]);

        foreach ($classes as $class) {
            yield $class;
        }
    }

    /**
     * @return array
     */
    protected function getMigrationList()
    {
        if (empty($this->migration_list)) {
            $this->setMigrationList();
        }

        return $this->migration_list;
    }

    /**
     * @throws \SilverStripe\ORM\ValidationException
     */
    protected function migrateHeaderImage()
    {
        /**
         * track the object ID's that have been updated to prevent running the update twice on the same record.
         * Note: This currently assumes all objects are decendents of SiteTree.
         */
        $updated = [];

        foreach ($this->getRecords() as $records) {
            foreach ($records as $record) {
                if ($record->HeaderImageID > 0) {
                    if (!in_array($record->ID, $updated)) {
                        $fileID = $record->HeaderImageID;

                        echo "Original Header Image File ID {$fileID}\n";

                        $versioned = $record->hasExtension(Versioned::class);

                        if ($versioned) {
                            $isPublished = $record->isPublished();
                        }

                        $headerImage = HeaderImage::create();
                        $headerImage->ImageID = $fileID;
                        $headerImage->write();

                        echo "New Header Image ID {$headerImage->ID} with related image {$headerImage->ImageID}\n";

                        $record->setComponent('HeaderImage', $headerImage);

                        $record->write();

                        if ($versioned) {
                            $record->writeToStage(Versioned::DRAFT);

                            if (isset($isPublished) && $isPublished) {
                                $record->publishRecursive();
                            }
                        }
                        $updated[] = $record->ID;
                    }
                }
            }
        }
    }

    /**
     * @return \Generator
     */
    protected function getRecords()
    {
        if (empty($this->getMigrationList())) {
            echo "No records to migrate\n";
        }

        foreach ($this->getMigrationList() as $class) {
            yield $this->yieldRecords($class);
        }
    }

    /**
     * @param $class
     * @return \Generator
     */
    protected function yieldRecords($class)
    {
        foreach ($class::get() as $record) {
            yield $record;
        }
    }
}
