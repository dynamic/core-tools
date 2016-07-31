<?php

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
        'Pages' => 'Page',
    );

    /**
     * @return ValidationResult
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Title) {
            $result->error('Title is requied before you can save');
        }

        return $result;
    }

    /**
     * @param null $member
     *
     * @return bool
     */
    public function canCreate($member = null)
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
