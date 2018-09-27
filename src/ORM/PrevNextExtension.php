<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Extension;

/**
 * Class PrevNextExtension
 * @package Dynamic\CoreTools\ORM
 */
class PrevNextExtension extends Extension
{
    /**
     * previous/next page links for pages in the same section
     *
     * @param string $mode
     * @return bool
     */
    public function PrevNext($mode = 'next')
    {
        switch ($mode) {
            case "next":
                $filter = "ParentID = (" . $this->owner->ParentID . ") AND Sort > (" . $this->owner->Sort . ")";
                $sort = "Sort ASC";
                break;
            case "prev":
                $filter = "ParentID = (" . $this->owner->ParentID . ") AND Sort < (" . $this->owner->Sort . ")";
                $sort = "Sort DESC";
                break;
            default:
                return false;
        }

        if ($page = SiteTree::get()->where($filter)->sort($sort)->first()) {
            return $page->Link();
        }
        return false;
    }
}
