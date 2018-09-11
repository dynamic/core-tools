<?php

namespace Dynamic\CoreTools\Tasks;

use Dynamic\CoreTools\Model\HeaderImage;
use Dynamic\CoreTools\ORM\HeaderImageDataExtension;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Dev\BuildTask;
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
            if ($class::singleton()->hasExtension(HeaderImageDataExtension::class)) {
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
        foreach ($this->getRecords() as $records) {
            foreach ($records as $record) {
                $versioned = $record->hasExtension(Versioned::class);

                if ($versioned) {
                    $isPublished = $record->isPublished();
                }

                $headerImage = HeaderImage::create();
                $headerImage->ImageID = $record->HeaderImageID;
                $headerImage->write();

                $record->HeaderImageID = $headerImage->ID;

                $record->write();

                if ($versioned) {
                    $record->writeToStage(Versioned::DRAFT);

                    if (isset($isPublished) && $isPublished) {
                        $record->publishRecursive();
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
