<?php

class TagManager extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->exists()) {
            $tagField = TagField::create('Tags', 'Tags', CoreTag::get(), $this->owner->Tags())
                ->setShouldLazyLoad(true)
                ->setCanCreate(true)
            ;
            $fields->insertBefore($tagField, 'Content');
        }
    }
}
