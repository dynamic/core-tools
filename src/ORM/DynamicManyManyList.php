<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\ManyManyList;
use SilverStripe\ORM\Queries\SQLDelete;
use Psr\Log\InvalidArgumentException;

/**
 * Class DynamicManyManyList
 * @package Dynamic\CoreTools\ORM
 */
class DynamicManyManyList extends ManyManyList
{

    /**
     * Remove the given item from this list.
     *
     * Note that for a ManyManyList, the item is never actually deleted, only
     * the join table is affected
     *
     * @param int $itemID The item ID
     */
    public function removeByID($itemID)
    {
        if (!is_numeric($itemID)) {
            throw new InvalidArgumentException("ManyManyList::removeById() expecting an ID");
        }

        $query = new SQLDelete("\"{$this->joinTable}\"");
        $foreignID = $this->getForeignID();

        $this->extend('onBeforeRemoveByID', $itemID, $this->joinTable,
          $foreignID);
        if ($filter = $this->foreignIDWriteFilter($foreignID)) {
            $query->setWhere($filter);
        } else {
            user_error("Can't call ManyManyList::remove() until a foreign ID is set",
              E_USER_WARNING);
        }

        $query->addWhere(array("\"{$this->localKey}\"" => $itemID));
        $query->execute();

        $this->extend('onAfterRemoveByID', $itemID, $this->joinTable,
          $foreignID);
    }

}