##SingleSortGroupedList

####Overview

The SingleSortGroupedList is inteded to add sort functionality on the list of grouped elements. This field does not handle complex sorting via arrays.

####Usage

**php**
```php
/**
 * @return GroupedList
 */
public function getSortedGroupedList()
{
    return SingleSortGroupedList::create($this->getMyList());
}
```

**.ss**
```html
<% if $MyList %>
    <% loop $SortedGroupedList.GroupedBy(valueOnListItem, Children, SortColumn, DESC) %>
        <h3>$Title</h3>
        <% loop $Children %>
            $Me
        <% end_loop %>
    <% end_loop %>
<% end_if %>
```