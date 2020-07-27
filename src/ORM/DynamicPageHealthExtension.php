<?php

namespace Dynamic\CoreTools\ORM;

use QuinnInteractive\Seo\Forms\GoogleSearchPreview;
use QuinnInteractive\Seo\Forms\HealthAnalysisField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\ORM\DataExtension;

class DynamicPageHealthExtension extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        parent::updateCMSFields($fields);

        if ($this->owner instanceof \SilverStripe\ErrorPage\ErrorPage) {
            return;
        }

        $fields->removeByName([
            'SEOHealthAnalysis'
        ]);

        $fields->addFieldsToTab('Root.SEO', [
            ToggleCompositeField::create('SEOHealthAnalysis', 'SEO Health Analysis', [
                GoogleSearchPreview::create(
                    'GoogleSearchPreview',
                    'Search Preview',
                    $this->getOwner(),
                    $this->owner->getRenderedHtmlDomParser()
                ),
                TextField::create('FocusKeyword', 'Set focus keyword'),
                HealthAnalysisField::create('ContentAnalysis', 'Content Analysis', $this->getOwner()),
            ])
        ]);
    }
}
