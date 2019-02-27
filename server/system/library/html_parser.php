<?php

use Sunra\PhpSimple\HtmlDomParser;

class HtmlParser {

    public function getDomHtml($string) {
        $dom = HtmlDomParser::str_get_html( $string,  $lowercase = true,  $forceTagsClosed = true,  $target_charset = DEFAULT_TARGET_CHARSET,  $stripRN = false,  $defaultBRText = DEFAULT_BR_TEXT,  $defaultSpanText = DEFAULT_SPAN_TEXT );
        return $dom;
    }

}