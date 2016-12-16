<?php

namespace Dynamic\CoreTools\Extensions;

use SilverStripe\ORM\DataExtension,
    SilverStripe\Forms\FieldList,
    SilverStripe\Forms\GridField\GridField,
    SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;

/**
 * Class PromoManager
 * @package Dynamic\CoreTools\Extensions
 */
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

/**
 * Class PromoRelation
 * @package Dynamic\CoreTools\Extensions
 */
class PromoRelation extends DataExtension
{
    private static $many_many = array(
        'Promos' => 'Dynamic\\CoreTools\\Model\\Promo',
    );

    private static $many_many_extraFields = array(
        'Promos' => array(
            'SortOrder' => 'Int',
        ),
    );
}