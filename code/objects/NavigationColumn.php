<?php

class NavigationColumn extends DataObject
{
    /**
     * @var array
     */
    private static $db = array(
        'Title' => 'Varchar(255)',
        'SortOrder' => 'Int',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'SiteConfig' => 'SiteConfig',
    );

    /**
     * @var array
     */
    private static $has_many = array(
        'NavigationGroups' => 'NavigationGroup',
    );

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName(array(
            'SiteConfigID',
            'SortOrder',
            'NavigationGroups',
        ));

        // navigation groups
        if ($this->ID) {
            $config = GridFieldConfig_RecordEditor::create();
            if (class_exists('GridFieldSortableRows')) {
                $config->addComponent(new GridFieldSortableRows('SortOrder'));
            }
            $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
            $config->removeComponentsByType('GridFieldDeleteAction');
            $config->addComponent(new GridFieldDeleteAction(false));
            $footerLinks = GridField::create('NavigationGroups', 'Navigation Groups', $this->NavigationGroups()->sort('SortOrder'), $config);

            $fields->addFieldsToTab('Root.Main', array(
                $footerLinks,
            ));
        }

        return $fields;
    }

    /**
     * @return mixed
     */
    public function validate()
    {
        $result = parent::validate();

        if (!$this->Title) {
            $result->error('A Title is required before you can save');
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
