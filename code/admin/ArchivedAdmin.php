<?php

/**
 * Class ArchivedAdmin
 */
class ArchivedAdmin extends ModelAdmin
{
    /**
     * @var string
     */
    private static $menu_title = 'Archive Admin';

    /**
     * @var string
     */
    private static $url_segment = 'archives';

    /**
     *
     */
    public function init()
    {
        parent::init();

        Requirements::css('core-tools/css/core-tools.css');
    }

    /**
     * @return SS_List
     */
    public function getList()
    {
        $list = parent::getList();

        $list = $list->alterDataQuery(function (DataQuery $dq) {
            $dq->setQueryParam('SoftDeletable.filter', false);
        });

        $list = $list->where('Deleted IS NOT NULL');

        return $list;
    }

    /**
     * @param null $id
     * @param null $fields
     *
     * @return $this|Form
     */
    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        if ($field = $form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
            $field->setConfig($config = GridFieldConfig_RecordViewer::create());
            $config->removeComponentsByType(GridFieldSoftDeleteAction::class);
            $config->addComponent(new GridFieldUnArchiveAction());
        }

        return $form;
    }

    /**
     * @return SearchContext
     */
    public function getSearchContext()
    {
        $context = parent::getSearchContext();

        $fields = $context->getFields();
        $fields->removeByName([
            'q[IncludeDeleted]',
            'q[OnlyDeleted]',
        ]);

        return $context;
    }

    /**
     * @return Generator
     */
    private function getArchiveClasses()
    {
        $models = SoftDeletable::listSoftDeletableClasses();

        foreach ($models as $model) {
            yield $model;
        }
    }

    /**
     * @return array Map of class name to an array of 'title' (see {@link $managed_models})
     */
    public function getManagedModels()
    {
        // Normalize models to have their model class in array key
        foreach ($this->getArchiveClasses() as $k => $v) {
            if (is_numeric($k)) {
                $models[$v] = ['title' => singleton($v)->i18n_plural_name()];
                unset($models[$k]);
            }
            if (!$v::singleton()->hasExtension(SoftDeletable::class)) {
                unset($models[$v]);
            }
        }

        if (!count($models)) {
            user_error(
                'ModelAdmin::getManagedModels():
				You need to specify at least one DataObject subclass in public static $managed_models.
				Make sure that this property is defined, and that its visibility is set to "public"',
                E_USER_ERROR
            );
        }

        return $models;
    }
}
