<?php

namespace Dynamic\CoreTools\ORM;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Dynamic\CoreTools\Model\EmailRecipient;

/**
 * Class RecipientManager
 * @package Dynamic\CoreTools\Extensions
 *
 * @property string $EmailSubject
 * @property string $ThankYouMessage
 */
class RecipientManager extends DataExtension
{
    /**
     * @var array
     */
    private static $db = array(
      'EmailSubject' => 'Varchar(200)',
      'ThankYouMessage' => 'HTMLText',
    );

    /**
     * @var array
     */
    private static $has_many = array(
      'Recipients' => EmailRecipient::class,
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName(array('PageID'));

        if ($this->owner->exists()) {
            $config = GridFieldConfig_RecordEditor::create()
              ->addComponent(new GridFieldOrderableRows('SortOrder'));
            $columns = $this->owner->Recipients()->sort('SortOrder');
            $tableField = GridField::create(
              'Recipients',
              _t('RecipientManager.Settings', 'Email Recipients'),
              $columns,
              $config
            );
            $tableField->setDescription(
              'Designate people to receive email notifications when someone completes the contact form.'
            );
            $fields->addFieldsToTab('Root.ContactForm', array(
              HeaderField::create('EmailRecipientHD', 'Email Notifications', 3),
              $tableField,
              TextField::create('EmailSubject'),
              HTMLEditorField::create('ThankYouMessage'),
            ));
        }
    }
}