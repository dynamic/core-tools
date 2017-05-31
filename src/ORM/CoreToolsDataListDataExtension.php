<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\Dev\Debug;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataObject;

/**
 * Class CoreToolsDataListDataExtension
 * @package Dynamic\CoreTools\Extensions
 */
class CoreToolsDataListDataExtension extends DataExtension
{

    /**
     * chainable method for DataObject::get()
     *
     * @param null $slug
     * @return bool
     */
    public function byUrlSegment($slug = null)
    {
        $object = singleton($this->owner->dataClass);
        //Debug::show($object);
        if ($slug === null || !($object instanceof DataObject) || !$object->hasDatabaseField('URLSegment')) {
            return false;
        }
        return $this->owner->filter('URLSegment', $slug)->first();
    }

}