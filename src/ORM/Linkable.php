<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\CMS\Model\SiteTree;

/**
 * Class Linkable.
 *
 * @property string $LinkType
 * @property string $ExternalLink
 * @property string $LinkLabel
 */
class Linkable extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
      'LinkType' => 'Enum("None, Internal, External")',
      'ExternalLink' => 'Varchar(255)',
      'LinkLabel' => 'Varchar(255)',
    );

    /**
     * @var array
     */
    private static $has_one = array(
      'PageLink' => SiteTree::class,
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
            if ($this->owner->LinkType == 'Internal' && $this->owner->PageLink()
                ->exists()
            ) {
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
        $fields->removeByName('PageLinkID');

        $tree = (class_exists('DisplayLogicWrapper'))
            ? DisplayLogicWrapper::create(
                TreeDropdownField::create('PageLinkID', 'Link to Page', SiteTree::class)
            )->displayIf('LinkType')->isEqualTo('Internal')->end()
            : TreeDropdownField::create('PageLinkID', 'Link to Page', SiteTree::class);

        $label = (class_exists('DisplayLogicWrapper'))
          ? TextField::create('LinkLabel', 'Link Label')
            ->displayIf('LinkType')
            ->isEqualTo('Internal')
            ->orIf('LinkType')
            ->isEqualTo('External')
            ->end()
          : TextField::create('LinkLabel', 'Link Label');

        $external = (class_exists('DisplayLogicWrapper'))
          ? TextField::create('ExternalLink', 'External URL')
            ->setAttribute('Placeholder', 'http://')
            ->displayIf('LinkType')->isEqualTo('External')->end()
          : TextField::create('ExternalLink', 'External URL');

        $fields->addFieldsToTab('Root.Link', array(
            OptionSetField::create(
                'LinkType',
                'Link',
                singleton($this->owner->ClassName)->dbObject('LinkType')->enumValues()
            ),
            $label,
            $tree,
            $external,
        ));
    }
}
