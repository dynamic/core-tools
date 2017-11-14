<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\GroupedList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

/**
 * Class SingleSortGroupedList.
 */
class SingleSortGroupedList extends GroupedList
{
    /**
     * Similar to {@link groupBy()}, but returns
     * the data in a format which is suitable for usage in templates.
     *
     * @param string $index
     * @param string $children  Name of the control under which children can be iterated on
     * @param string $sort      The field to sort the Children on
     * @param string $direction The sort direction
     *
     * @return ArrayList
     */
    public function GroupedBy(
        $index,
        $children = 'Children',
        $sort = null,
        $direction = 'ASC'
    ) {
        $grouped = $this->groupBy($index);
        $result = new ArrayList();
        $direction = ($direction == 'ASC' || $direction == 'DESC') ? $direction : 'ASC';

        foreach ($grouped as $indVal => $list) {
            $list = GroupedList::create($list);
            if ($sort !== null && $list->canSortBy($sort)) {
                $list = $list->sort([$sort => $direction]);
            }
            $result->push(new ArrayData(array(
              $index => $indVal,
              $children => $list,
            )));
        }

        return $result;
    }
}
