<?php

namespace Dynamic\CoreTools\Extensions;

use SilverStripe\Forms\CheckboxSetField,
    SilverStripe\ORM\DataExtension,
    SilverStripe\Forms\FieldList;

/**
 * Class TagManager
 * @package Dynamic\CoreTools\Extensions
 */
class TagManager extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->exists()) {
            if (class_exists('Tag')) {
                $tagField = (class_exists('TagField'))
                    ? TagField::create('Tags', 'Tags', Tag::get(), $this->owner->Tags())
                        ->setShouldLazyLoad(true)
                        ->setCanCreate(true)
                    : CheckboxSetField::create('Tags')
                        ->setSource(Tag::get()->map());
                $fields->insertBefore($tagField, 'Content');
            }
        }
    }
}
