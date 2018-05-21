<?php

namespace Dynamic\CoreTools\Tests\Model;

use Dynamic\CoreTools\Model\GlobalSiteSetting;
use SilverStripe\Dev\SapphireTest;

/**
 * Class GlobalSiteSettingTest
 * @package Dynamic\CoreTools\Tests\Model
 */
class GlobalSiteSettingTest extends SapphireTest
{
    /**
     * Small helper to render templates from strings
     *
     * Note: with the updated gitattributes for framework, we don't
     * get TestFixture as the Test directory isn't included when building on Travis
     * causing failures. We'll want to look at finding a way to re-implement this.
     *
     * @param  string $templateString
     * @param  null $data
     * @param  bool $cacheTemplate
     *
     * @return string
     */
    /*public function render($templateString, $data = null, $cacheTemplate = false)
    {
        $t = SSViewer::fromString($templateString, $cacheTemplate);
        if (!$data) {
            $data = new TestFixture();
        }

        return trim('' . $t->process($data));
    }*/

    /**
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function testGlobalTemplateVariables()
    {
        $config = GlobalSiteSetting::current_global_config();

        $this->assertEquals(0, $config->ReviewContent);

        //$this->assertEquals(0, $this->render('$ReviewContent'));

        $config->ReviewContent = true;
        $config->write();

        $config = GlobalSiteSetting::current_global_config();
        $this->assertEquals(1, $config->ReviewContent);

        //$this->assertEquals(1, $this->render('$ReviewContent'));
    }
}
