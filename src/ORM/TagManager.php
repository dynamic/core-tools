<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use Dynamic\CoreTools\Model\Tag;

/**
 * Class TagManager.
 */
class TagManager extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->exists()) {
            if (class_exists(Tag::class)) {
                $tagField = (class_exists(TagField::class))
                    ? TagField::create(
                        'Tags',
                        'Tags',
                        Tag::get(),
                        $this->owner->Tags()
                    )
                        ->setShouldLazyLoad(true)
                        ->setCanCreate(true)
                    : CheckboxSetField::create('Tags')
                        ->setSource(Tag::get()->map());
                $fields->insertBefore($tagField, 'Content');
            }
        }
    }
}
