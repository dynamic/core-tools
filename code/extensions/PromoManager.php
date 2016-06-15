<?php

class PromoManager extends DataExtension
{
    public function getPromoList()
    {
        return $this->owner->Promos()->sort('SortOrder');
    }

    public function updateCMSFields(FieldList $fields)
    {
        // add Spiff grid field if record exists
        if ($this->owner->exists()) {
            $config = GridFieldConfig_RelationEditor::create();
            if (class_exists('GridFieldSortableRows')) {
                $config->addComponent(new GridFieldSortableRows('SortOrder'));
            }
            if (class_exists('GridFieldAddExistingSearchButton')) {
                $config->removeComponentsByType('GridFieldAddExistingAutocompleter');
                $config->addComponent(new GridFieldAddExistingSearchButton());
            }
            $promos = $this->owner->Promos()->sort('SortOrder');
            $promoField = GridField::create('Promos', 'Promos', $promos, $config);

            $fields->addFieldsToTab('Root.Promos', array(
                $promoField,
            ));
        }
    }
}
