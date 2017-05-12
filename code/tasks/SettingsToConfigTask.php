<?php

/**
 * Class SettingsToConfigTask
 */
class SettingsToConfigTask extends BuildTask
{

    /**
     * @param $reuqest
     */
    public function run($reuqest)
    {

        $siteConfig = SiteConfig::current_site_config();
        $config = GlobalSiteSetting::current_global_config();

        if ($siteConfig->hasExtension('Addressable')) {
            foreach (Config::inst()
                         ->get('Addressable', 'db') as $key => $value) {
                $config->$key = $siteConfig->$key;
            }
        }

        if ($siteConfig->hasExtension('Geocodable')) {
            foreach (Config::inst()
                         ->get('Geocodable', 'db') as $key => $value) {
                $config->$key = $siteConfig->$key;
            }
        }

        if ($siteConfig->hasExtension('CompanyConfig')) {
            foreach (Config::inst()
                         ->get('CompanyConfig', 'db') as $key => $value) {
                $config->$key = $siteConfig->$key;
            }
        }

        if ($siteConfig->hasExtension('TemplateConfig') && $config->hasExtension('TemplateConfig')) {
            $config->TitleLogo = $siteConfig->TitleLogo;
            $config->LogoID = $siteConfig->LogoID;
        }

        $config->write();

        if ($siteConfig->hasExtension('UtilityNavigationManager')) {
            $configLinks = $config->UtilityLinks();
            foreach ($siteConfig->UtilityLinks() as $link) {
                $configLinks->add($link, ['SortOrder' => $link->SortOrder]);
            }
        }

        if ($siteConfig->hasExtension('FooterNavigationManager')) {
            $configLinks = $config->NavigationColumns();
            foreach ($siteConfig->NavigationColumns() as $link) {
                $configLinks->add($link);
            }
        }

    }

}