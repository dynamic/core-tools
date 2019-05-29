<?php

namespace Dynamic\CoreTools\Tasks;

use Dynamic\Core\Model\Spiff;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\BuildTask;

class SpiffMigrationTask extends BuildTask
{
    /**
     * @var string
     */
    protected $title = 'Core Tools - Spiff Migration Task';

    /**
     * @var string
     */
    protected $description = 'Migrate Core Tools Spiffs - Headline field to Title.';

    /**
     * @var string
     */
    private static $segment = 'core-tools-spiff-migration-task';

    /**
     * @param HTTPRequest $request
     */
    public function run($request)
    {
        $spiffs = Spiff::get();
        $ct = 0;

        foreach ($spiffs as $spiff) {
            if ($spiff->Headline && !$spiff->Title) {
                $spiff->Title = $spiff->Headline;
                $spiff->write();
                $ct++;
            }
        }
        echo $ct . ' spiffs updated.';
    }
}
