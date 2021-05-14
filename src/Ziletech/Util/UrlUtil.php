<?php

namespace Ziletech\Util;

class UrlUtil {

    public static function post($url, $data) {
        $jsonString = json_encode($data);
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => $jsonString
            )
        );
        $context = stream_context_create($opts);
        $content = file_get_contents($url, false, $context);
        return $content;
    }
    
    public static function formPost($url, $data) {
       $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data) 
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result);
    }

}
