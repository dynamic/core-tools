<?php

class CoreToolsPageFieldsDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'SubTitle' => 'Varchar(255)',
        'PageTitle' => 'Varchar(255)',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->insertAfter(TextField::create('SubTitle', 'Sub Title'), 'MenuTitle');

        $fields->removeByName('Metadata');
        $meta = ToggleCompositeField::create('Metadata', _t('SiteTree.MetadataToggle', 'Metadata'),
            array(
                $metaTitle = new TextField('PageTitle', 'Page Title'),
                $metaFieldDesc = new TextareaField('MetaDescription', 'MetaDescription'),
                $metaFieldExtra = new TextareaField('ExtraMeta', 'ExtraMeta'),
            )
        )->setHeadingLevel(4);
        // Help text for MetaData on page content editor
        $metaFieldDesc
            ->setRightTitle(
                _t(
                    'SiteTree.METADESCHELP',
                    'Search engines use this content for displaying search results (although it will not influence their ranking).'
                )
            )
            ->addExtraClass('help');
        $metaFieldExtra
            ->setRightTitle(
                _t(
                    'SiteTree.METAEXTRAHELP',
                    'HTML tags for additional meta information. For example &lt;meta name="customName" content="your custom content here" /&gt;'
                )
            )
            ->addExtraClass('help');
        $fields->addFieldToTab('Root.Main', $meta);
    }
}
