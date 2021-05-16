<?php

namespace Ziletech\Util;

class StringUtil {

    public static function isNotEmpty($str): bool {
        return ! StringUtil::isEmpty($str);
    }

    public static function isEmpty($str): bool {
        return (!isset($str) || trim($str) === '');
    }

}
