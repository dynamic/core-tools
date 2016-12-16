<?php

/**
 * Action that takes the user back to a given link rather than submitting
 * the form.
 *
 * @package cancelformaction
 */
class CancelFormAction extends FormAction
{
    /**
     * @var string
     */
    private $link;

    /**
     * CancelFormAction constructor.
     * @param string $link
     * @param string $title
     * @param null $form
     * @param null $extraData
     * @param string $extraClass
     */
    public function __construct($link = "", $title = "", $form = null, $extraData = null, $extraClass = '')
    {
        if (!$title) {
            $title = _t('CancelFormAction.CANCEL', 'Cancel');
        }

        $this->setLink($link);

        parent::__construct('CancelFormAction', $title, $form, $extraData, $extraClass);
    }

    /**
     * @param $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param array $properties
     * @return string
     */
    public function Field($properties = array())
    {
        $attributes = array(
            'class' => 'cancel btn ' . ($this->extraClass() ? $this->extraClass() : ''),
            'id' => $this->id(),
            'name' => $this->action,
            'href' => $this->getLink()
        );

        if ($this->isReadonly()) {
            $attributes['disabled'] = 'disabled';
            $attributes['class'] = $attributes['class'] . ' disabled';
        }

        return $this->createTag(
            'a',
            $attributes,
            $this->buttonContent ? $this->buttonContent : $this->Title()
        );
    }
}
