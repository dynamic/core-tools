<?php

define('CORE_TOOLS_PATH', __DIR__);
define('CORE_TOOLS_DIR', basename(__DIR__));

// set image upload max size
define('CORE_TOOLS_IMAGE_SIZE_LIMIT', '1024000');

\SilverStripe\View\Parsers\ShortcodeParser::get('default')->unregister('embed');
\SilverStripe\View\Parsers\ShortcodeParser::get('default')->register(
    'embed',
    function ($arguments, $content = null, $parser = null, $tagName = null) {
        return \Dynamic\CoreTools\View\CTEmbedShortcodeProvider::handle_shortcode(
            $arguments,
            $content,
            $parser,
            $tagName
        );
    }
);
