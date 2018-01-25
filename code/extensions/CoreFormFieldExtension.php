<?php

/**
 * Class CoreFormFieldExtension
 */
class CoreFormFieldExtension extends DataExtension
{

    /**
     * @var array
     */
    private static $db = array(
        'FieldWidth' => "Enum('full,half', 'full')",
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab('Root.Main',
            DropdownField::create(
                'FieldWidth',
                'Width of Field',
                $this->owner->dbObject('FieldWidth')->enumValues()
            ), 'ExtraClass'
        );
    }

    /**
     * @param FormField $field
     */
    public function afterUpdateFormField(FormField $field)
    {
        $field->addExtraClass($this->owner->FieldWidth);
    }
}
