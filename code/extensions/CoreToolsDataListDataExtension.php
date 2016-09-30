<?php

/**
 * Class CoreToolsDataListDataExtension
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
        if ($slug === null || !($object instanceof DataObject) || !array_key_exists('URLSegment',
                DataObject::database_fields($this->owner->dataClass))
        ) {
            return false;
        }
        return $this->owner->filter('URLSegment', $slug)->first();
    }

}