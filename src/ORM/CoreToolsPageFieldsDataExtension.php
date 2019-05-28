<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\Forms\TextareaField;

/**
 * Class CoreToolsPageFieldsDataExtension.
 *
 * @property string $SubTitle
 * @property string $PageTitle
 */
class CoreToolsPageFieldsDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
      'PageTitle' => 'Varchar(255)',
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('Metadata');

        $meta = ToggleCompositeField::create(
            'Metadata',
            _t('SiteTree.MetadataToggle', 'Metadata'),
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
                    'Search engines use this content for displaying search results
                    (although it will not influence their ranking).'
                )
            )
            ->addExtraClass('help');
        $metaFieldExtra
            ->setRightTitle(
                _t(
                    'SiteTree.METAEXTRAHELP',
                    'HTML tags for additional meta information.
                        For example <meta name="customName" content="your custom content here" />'
                )
            )
            ->addExtraClass('help');
        $fields->addFieldToTab('Root.Main', $meta);
    }
}
