<?php

class Linkable extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
        'LinkType' => 'Enum("None, Internal, External", "None")',
        'ExternalLink' => 'Varchar(255)',
        'LinkLabel' => 'Varchar(255)',
    );

    /**
     * @var array
     */
    private static $has_one = array(
        'PageLink' => 'SiteTree',
    );

    /**
     * @var array
     */
    private static $defaults = array(
        'LinkType' => 'None',
    );

    /**
     * @return string
     */
    public function getLinkStatus()
    {
        if ($this->owner->LinkType != 'None') {
            if ($this->owner->LinkType == 'Internal' && $this->owner->PageLink()->exists()) {
                return 'internal';
            }
            if ($this->owner->LinkType == 'External' && $this->owner->ExternalLink) {
                return 'external';
            }

            return 'error';
        }

        return 'no';
    }

    /**
     * @return string
     */
    public function LinkStatus()
    {
        return $this->getLinkStatus();
    }

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(array(
            'PageLinkID',
            'LinkType',
            'ExternalLink',
            'LinkLabel',
        ));

        $linkFields = FieldList::create(
            OptionSetField::create('LinkType', 'Link', singleton($this->owner->class)->dbObject('LinkType')->enumValues()),
            DisplayLogicWrapper::create(
                TreeDropdownField::create('PageLinkID', 'Link to Page', 'SiteTree')
            )->displayIf('LinkType')->isEqualTo('Internal')->end(),
            TextField::create('ExternalLink', 'External URL')
                ->setAttribute('Placeholder', 'http://')
                ->displayIf('LinkType')->isEqualTo('External')->end(),
            TextField::create('LinkLabel', 'Link Label')
                ->displayIf('LinkType')->isEqualTo('Internal')->orIf('LinkType')->isEqualTo('External')->end()
        );

        // Link Field
        $linkField = ToggleCompositeField::create('LinkHD', 'Featured Link', $linkFields)
            ->setHeadingLevel(4)
            ->setStartClosed(true)
        ;
        $fields->addFieldToTab('Root.Main', $linkField, 'Content');
    }
}
