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
                return 'yes';
            }
            if ($this->owner->LinkType == 'External' && $this->owner->ExternalLink) {
                return 'yes';
            }
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
        $fields->removeByName('PageLinkID');
        $fields->addFieldsToTab('Root.Link', array(
            OptionSetField::create('LinkType', 'Link', singleton($this->owner->class)->dbObject('LinkType')->enumValues()),
            TextField::create('LinkLabel', 'Link Label')
                ->displayIf('LinkType')->isEqualTo('Internal')->orIf('LinkType')->isEqualTo('External')->end(),
            DisplayLogicWrapper::create(
                TreeDropdownField::create('PageLinkID', 'Link to Page', 'SiteTree')
            )->displayIf('LinkType')->isEqualTo('Internal')->end(),
            TextField::create('ExternalLink', 'External URL')
                ->setAttribute('Placeholder', 'http://')
                ->displayIf('LinkType')->isEqualTo('External')->end(),
        ));
    }
}
