<?php

class UtilityNavigationManager extends DataExtension
{
    /**
     * @var array
     */
    private static $many_many = array(
        'UtilityLinks' => 'SiteTree',
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'UtilityLinks' => array(
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->ID && $this->owner->ClassName != 'SiteConfig') {
            $config = GridFieldConfig_RelationEditor::create();
            if (class_exists('GridFieldOrderableRows')) {
                $config->addComponent(new GridFieldOrderableRows('SortOrder'));
            }
            if (class_exists('GridFieldAddExistingSearchButton')) {
                $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
                $config->addComponent(new GridFieldAddExistingSearchButton());
            }
            $config->removeComponentsByType($config->getComponentByType('GridFieldAddNewButton'));
            $promos = $this->owner->UtilityLinks()->sort('SortOrder');
            $linksField = GridField::create('UtilityLinks', 'Utility Links', $promos, $config);

            $fields->addFieldsToTab('Root.Utility', array(
                $linksField,
            ));
        }
    }

}