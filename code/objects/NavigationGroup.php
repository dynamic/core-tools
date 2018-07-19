<?php

class NavigationGroup extends DataObject
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
        'NavigationColumn' => 'NavigationColumn',
    );

    /**
     * @var array
     */
    private static $many_many = array(
        'NavigationLinks' => 'SiteTree',
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'NavigationLinks' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @var string
     */
    private static $default_sort = 'SortOrder';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function($fields) {
            /** @var \FieldList $fields */
            $fields->removeByName(array(
                'SortOrder',
                'NavigationColumnID',
                'NavigationLinks',
            ));

            if ($this->ID) {
                $config = GridFieldConfig_RelationEditor::create();
                $config->removeComponentsByType(GridFieldAddNewButton::class)
                    ->removeComponentsByType(GridFieldSortableHeader::class)
                    ->addComponents(new GridFieldTitleHeader());

                if (class_exists('GridFieldOrderableRows')) {
                    $config->addComponent(new GridFieldOrderableRows('SortOrder'));
                }
                if (class_exists('GridFieldAddExistingSearchButton')) {
                    $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
                    $config->addComponent(new GridFieldAddExistingSearchButton());
                }
                $promos = $this->NavigationLinks()->sort('SortOrder');
                $linksField = GridField::create('NavigationLinks', 'Navigation Links', $promos, $config);

                $fields->addFieldsToTab('Root.Main', array(
                    $linksField,
                ));
            }
        });

        return parent::getCMSFields();
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
