<?php

class ManyLinksManager extends DataExtension
{
    /**
     * @var array
     */
    private static $many_many = array(
        'ActionLinks' => 'SiteTree',
    );

    /**
     * @var array
     */
    private static $many_many_extraFields = array(
        'ActionLinks' => array(
            'LinkLabel' => 'Varchar(255)',
            'SortOrder' => 'Int',
        ),
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(array(
            'ActionLinks',
        ));

        if ($this->owner->ID) {

            $config = GridFieldConfig_RelationEditor::create();
            if (class_exists('GridFieldSortableRows')) {
                $config->addComponent(new GridFieldSortableRows('SortOrder'));
            }
            if (class_exists('GridFieldAddExistingSearchButton')) {
                $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
                $config->addComponent(new GridFieldAddExistingSearchButton());
            }
            $config->removeComponentsByType('GridFieldAddNewButton');

            // LinkLabel
            $linkFields = FieldList::create(
                TextField::create('ManyMany[LinkLabel]', 'Link Label')
            );

            $config->removeComponentsByType(new GridFieldDetailForm());
            $config->removeComponentsByType(new GridFieldDataColumns());

            $edittest = new GridFieldDetailForm();
            $edittest->setFields($linkFields);

            $summaryfieldsconf = new GridFieldDataColumns();
            $summaryfieldsconf->setDisplayFields(array(
                'MenuTitle' => 'Menu Title',
                'URLSegment' => 'URLSegment',
                'LinkLabel' => 'Link Label',
            ));

            $config->addComponent($edittest);
            $config->addComponent($summaryfieldsconf, new GridFieldFilterHeader());

            $linksField = GridField::create('ActionLinks', 'Links', $this->owner->ActionLinks()->sort('SortOrder'), $config);

            $fields->addFieldToTab('Root.Links', $linksField);
        }
    }
}