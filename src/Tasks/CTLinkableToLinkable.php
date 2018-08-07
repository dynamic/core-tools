<?php

namespace Dynamic\CoreTools\Tasks;

use Dynamic\CoreTools\ORM\Linkable;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

/**
 * Class CTLinkableToLinkable
 * @package Dynamic\CoreTools\Tasks
 */
class CTLinkableToLinkable extends BuildTask
{
    /**
     * Set a custom url segment (to follow dev/tasks/)
     *
     * @config
     * @var string
     */
    private static $segment = 'ct-linkable-to-linkable';

    /**
     * @var bool $enabled If set to FALSE, keep it from showing in the list
     * and from being executable through URL or CLI.
     */
    protected $enabled = true;

    /**
     * @var string $title Shown in the overview on the {@link TaskRunner}
     * HTML or CLI interface. Should be short and concise, no HTML allowed.
     */
    protected $title = 'Core Tools Linkable to Linkable Module Task';

    /**
     * @var string $description Describe the implications the task has,
     * and the changes it makes. Accepts HTML formatting.
     */
    protected $description = 'Migrate Core Tools Linkable DataExtension data to Linkable Module Link records.';

    /**
     * @var array
     */
    private $classes = [];

    /**
     * @var array
     */
    private $relation_tracking = [];

    /**
     * @param \SilverStripe\Control\HTTPRequest $request
     */
    public function run($request)
    {
        $this->setClasses();
        $this->migrateLinkData();
    }

    /**
     * @return $this
     */
    protected function setClasses()
    {
        foreach ($this->getHierarchy() as $class) {
            if ($class::singleton()->hasExtension(Linkable::class) && $this->hasLinkableRelation($class)) {
                $this->classes[$class] = $relation;
            }
        }

        return $this;
    }

    /**
     * @return \Generator
     */
    protected function getClasses()
    {
        foreach ($this->classes as $key => $val) {
            yield $val;
        }
    }

    /**
     * @return \Generator
     */
    private function getHierarchy()
    {
        foreach (ClassInfo::subclassesFor(DataObject::class) as $class) {
            yield $class;
        }
    }

    /**
     * @param $class
     * @return bool
     */
    private function hasLinkableRelation($class)
    {
        foreach ($class::singleton()->config()->get('has_one') as $key => $val) {
            if ($class::singleton()->getRelationClass($key) == Link::class) {
                $this->setRelationTracking($class, $key);

                return true;
            }
        }
        return false;
    }

    /**
     * @param $class
     * @param $relatinName
     * @return $this
     */
    private function setRelationTracking($class, $relatinName)
    {
        $this->relation_tracking[$class] = $relatinName;

        return $this;
    }

    /**
     * @param $class
     * @return bool|mixed
     */
    private function getRelationName($class)
    {
        if (isset($this->relation_tracking[$class])) {
            return $this->relation_tracking[$class];
        }

        return false;
    }

    /**
     *
     */
    protected function migrateLinkData()
    {
        foreach ($this->getClasses() as $class) {
            $relationName = $this->getRelationName($class);
            foreach ($this->iterateObjects($class) as $object) {
                $this->processObject($object, $relationName);
            }
        }
    }

    /**
     * @param $class
     * @return \Generator
     */
    protected function iterateObjects($class)
    {
        foreach ($class::get() as $object) {
            yield $object;
        }
    }

    /**
     * @param $object
     */
    protected function processObject($object, $relationName)
    {
        $newLink = Link::create();

        if ($object->LinkLabel) $newLink->Title = $object->LinkLabel;

        switch ($object->LinkType) {
            case 'Internal':
                $newLink->SiteTreeID = $object->PageLinkID;
                $newLink->Type = 'SiteTree';
                break;
            case 'External':
                $newLink->URL = $object->ExternalLink;
                $newLink->OpenInNewWindow = true;
                break;
            default:
                //Legacy linkable didn't have values, so do nothing
                $skipWrite = true;
                break;
        }

        if (!isset($skipWrite)) {
            $newLink->write();
            static::write_line("New link object created with ID {$newLink->ID}\n");

            $relationID = $relationName . 'ID';
            $object->$relationID = $newLink->ID;

            if ($object->hasExtension(Versioned::class)) {
                $versioned = true;
                $publishState = $object->isPublished();
            }

            if (isset($versioned)) {
                $object->writeToStage(Versioned::DRAFT);
                static::write_line("{$object->ClassName} with ID {$object->ID} associated with link record {$newLink->ID}\n");
                if ($publishState) {
                    $object->publishRecursively();
                    static::write_line("\t{$object->ClassName} with ID {$object->ID} published\n");
                }
            } else {
                $object->write();
                static::write_line("{$object->ClassName} with ID {$object->ID} associated with link record {$newLink->ID}\n");
            }

        }
    }

    /**
     * @param string $message
     */
    private static function write_line($message = '')
    {
        echo "$message";
    }
}