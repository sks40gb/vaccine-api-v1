<?php

namespace Ziletech\Util;

class StringUtil {

    public static function isNotEmpty($str) {
        return ! StringUtil::isEmpty($str);
    }

    public static function isEmpty($str) {
        return (!isset($str) || trim($str) === '');
    }

}
