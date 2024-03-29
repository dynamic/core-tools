<?php

namespace Dynamic\CoreTools\ORM;

use QuinnInteractive\Seo\Builders\FacebookMetaGenerator;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\ORM\DataExtension;

class DynamicPageSeoExtension extends DataExtension
{
    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        parent::updateCMSFields($fields);

        $fields->removeByName([
            'FacebookSeoComposite',
            'TwitterSeoComposite',
        ]);

        $fields->addFieldsToTab('Root.SEO', [
            ToggleCompositeField::create('FacebookSeoComposite', 'Facebook SEO', [
                DropdownField::create('FacebookPageType', 'Type', FacebookMetaGenerator::getValidTypes()),
                TextField::create('FacebookPageTitle', 'Title')
                    ->setAttribute('placeholder', $this->getOwner()->Title)
                    ->setRightTitle('If blank, inherits default page title')
                    ->setTargetLength(45, 25, 70),
                UploadField::create('FacebookPageImage', 'Image')
                    ->setRightTitle('Facebook recommends images to be 1200 x 630 pixels. If no image is
                        provided, facebook will choose the first image that appears on the page which usually has
                        bad results')
                    ->setFolderName('seo'),
                TextareaField::create('FacebookPageDescription', 'Description')
                    ->setAttribute(
                        'placeholder',
                        $this->getOwner()->MetaDescription ?:
                            $this->getOwner()->dbObject('Content')->LimitCharacters(297))
                    ->setRightTitle('If blank, inherits meta description if it exists or gets the first 297
                        characters from content')
                    ->setTargetLength(200, 160, 320),
            ]),
            ToggleCompositeField::create('TwitterSeoComposite', 'Twitter SEO', [
                TextField::create('TwitterPageTitle', 'Title')
                    ->setAttribute('placeholder', $this->getOwner()->Title)
                    ->setRightTitle('If blank, inherits default page title')
                    ->setTargetLength(45, 25, 70),
                UploadField::create('TwitterPageImage', 'Image')
                    ->setRightTitle('Must be at least 280x150 pixels')
                    ->setFolderName('seo'),
                TextareaField::create('TwitterPageDescription', 'Description')
                    ->setAttribute(
                        'placeholder',
                        $this->getOwner()->MetaDescription ?:
                            $this->getOwner()->dbObject('Content')->LimitCharacters(297))
                    ->setRightTitle('If blank, inherits meta description if it exists or gets the first 297
                        characters from content')
                    ->setTargetLength(200, 160, 320),
            ])
        ]);
    }
}
