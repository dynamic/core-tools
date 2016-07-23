<?php

class CollectionExtension extends Extension
{
    /**
     * @var array
     */
    private static $allowed_actions = array(
        'CollectionSearchForm'
    );

    /**
     * @return string
     */
    public function getCollectionObject()
    {
        if ($object = $this->owner->config()->managed_object) {
            return (string)$object;
        }
        return 'Page';
    }

    /**
     * @return int
     */
    public function getCollectionSize()
    {
        if ($object = $this->owner->config()->page_size) {
            return (int)$object;
        }
        return 10;
    }

    /**
     * @param array $searchCriteria
     * @return PaginatedList
     */
    public function CollectionItems($searchCriteria = array())
    {
        $request = ($this->owner->request) ? $this->owner->request : $this->owner->parentController->getRequest();
        if (empty($searchCriteria)) {
            $searchCriteria = $request->requestVars();
        }

        // customize searchCriteria
        if (method_exists($this->owner->Classname, 'getCustomFilters')) {
            foreach ($this->owner->getCustomFilters() as $key => $value) {
                $searchCriteria[$key] = $value;
            }
        }

        $object = $this->getCollectionObject();
        $sort = ($request->getVar('Sort')) ? (string)$request->getVar('Sort') : singleton($object)->stat('default_sort');

        $start = ($request->getVar('start')) ? (int)$request->getVar('start') : 0;
        $context = (method_exists($object, 'getCustomSearchContext')) ? singleton($object)->getCustomSearchContext() : singleton($object)->getDefaultSearchContext();

        $records = $context->getResults($searchCriteria)
            ->sort($sort);
        $records = PaginatedList::create($records, $this->owner->request);
        $records->setPageStart($start);
        $records->setPageLength($this->getCollectionSize());
        return $records;
    }

    /**
     * @return mixed
     */
    public function CollectionSearchForm()
    {
        $object = $this->getCollectionObject();
        $context = (method_exists($object, 'getCustomSearchContext')) ? singleton($object)->getCustomSearchContext() : singleton($object)->getDefaultSearchContext();
        $fields = $context->getSearchFields();

        $request = ($this->owner->request) ? $this->owner->request : $this->owner->parentController->getRequest();
        $sort = ($request->getVar('Sort')) ? (string)$request->getVar('Sort') : singleton($object)->stat('default_sort');

        // add sort field if managed object specs getSortOptions()
        if (method_exists($object, 'getSortOptions')) {
            $sortOptions = singleton($object)->getSortOptions();
            $defaultSort = array(singleton($object)->stat('default_sort') => 'Default');
            $sortOptions = array_merge($defaultSort, $sortOptions);
            $fields->add(
                DropdownField::create('Sort', 'Sort by:', $sortOptions, $sort)
            );
        }

        $actions = new FieldList(
            new FormAction('collectionSearch', 'Search')
        );

        if (class_exists('BootstrapForm')) {
            $form = BootstrapForm::create(
                $this->owner,
                'CollectionSearchForm',
                $fields,
                $actions
            );
        } else {
            $form = Form::create(
                $this->owner,
                'CollectionSearchForm',
                $fields,
                $actions
            );
        }
        $form
            ->setFormMethod('get')
            ->disableSecurityToken()
        ;
        return $form;
    }

    /**
     * Results filtered by query
     *
     * @param $data
     * @param $form
     * @param $request
     * @return string
     */
    public function collectionSearch($data, $form, $request)
    {
        return $this->owner->render(array(
            'Items' => $this->owner->CollectionItems($data),
            'AdvSearchForm' => $form
        ));
    }
}
