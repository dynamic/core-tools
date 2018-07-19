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
        'GlobalConfig' => 'GlobalSiteSetting',
    );

    /**
     * @var array
     */
    private static $has_many = array(
        'NavigationGroups' => 'NavigationGroup',
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
                'SiteConfigID',
                'GlobalConfigID',
                'SortOrder',
                'NavigationGroups',
            ));

            // navigation groups
            if ($this->ID) {
                $config = GridFieldConfig_RecordEditor::create();
                $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class)
                    ->removeComponentsByType(GridFieldDeleteAction::class)
                    ->addComponents(new GridFieldDeleteAction(false));

                if (class_exists('GridFieldTitleHeader')) {
                    $config->removeComponentsByType(GridFieldSortableHeader::class)
                        ->addComponent(new GridFieldTitleHeader());
                }
                if (class_exists('GridFieldOrderableRows')) {
                    $config->addComponent(new GridFieldOrderableRows('SortOrder'));
                }

                $footerLinks = GridField::create('NavigationGroups', 'Navigation Groups', $this->NavigationGroups()->sort('SortOrder'), $config);

                $fields->addFieldsToTab('Root.Main', array(
                    $footerLinks,
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
