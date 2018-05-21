<?php

namespace Dynamic\CoreTools\View;

use SilverStripe\Core\Convert;
use SilverStripe\View\HTML;
use SilverStripe\View\Shortcodes\EmbedShortcodeProvider as SSEmbedShortcodeProvider;

class CTEmbedShortcodeProvider extends SSEmbedShortcodeProvider
{
    /**
     * @param Adapter $embed
     * @param array $arguments Additional shortcode params
     * @return string
     */
    public static function embedForTemplate($embed, $arguments)
    {
        switch ($embed->getType()) {
            case 'video':
            case 'rich':
                // Attempt to inherit width (but leave height auto)
                if (empty($arguments['width']) && $embed->getWidth()) {
                    $arguments['width'] = $embed->getWidth();
                }
                return static::videoEmbed($arguments, $embed->getCode());
            case 'link':
                return static::linkEmbed($arguments, $embed->getUrl(), $embed->getTitle());
            case 'photo':
                return static::photoEmbed($arguments, $embed->getUrl());
            default:
                return null;
        }
    }

    /**
     * Build video embed tag
     *
     * @param array $arguments
     * @param string $content Raw HTML content
     * @return string
     */
    protected static function videoEmbed($arguments, $content)
    {
        $arguments['class'] = 'embed-responsive embed-responsive-16by9';

        return parent::videoEmbed($arguments, $content);
    }
}
