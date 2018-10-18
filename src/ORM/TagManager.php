<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use Dynamic\CoreTools\Model\CoreTag;

/**
 * Class TagManager.
 */
class TagManager extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->exists()) {
            if (class_exists(CoreTag::class)) {
                $tagField = (class_exists(TagField::class))
                    ? TagField::create(
                        'Tags',
                        'Tags',
                        CoreTag::get(),
                        $this->owner->Tags()
                    )
                        ->setShouldLazyLoad(true)
                        ->setCanCreate(true)
                    : CheckboxSetField::create('Tags')
                        ->setSource(CoreTag::get()->map());
                $fields->insertBefore($tagField, 'Content');
            }
        }
    }
}
