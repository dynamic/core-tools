<?php

namespace Dynamic\CoreTools\Model;

use SilverStripe\ORM\DataObject;
use Page;

/**
 * Class Tag.
 *
 * @property string $Title
 */
class Tag extends DataObject
{
    /**
     * @var array
     */
    private static $db = array(
      'Title' => 'Varchar(200)',
    );

    /**
     * @var array
     */
    private static $belongs_many_many = array(
      'Pages' => Page::class,
    );

    /**
     * @var string
     */
    private static $table_name = 'Tag';

    /**
     * @return \SilverStripe\ORM\ValidationResult;
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Title) {
            $result->addError('Title is required before you can save');
        }

        return $result;
    }

    /**
     * @param null  $member
     * @param array $context
     *
     * @return bool
     */
    public function canCreate($member = null, $context = [])
    {
        return true;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canView($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canEdit($member = null)
    {
        return true;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canDelete($member = null)
    {
        return true;
    }
}
