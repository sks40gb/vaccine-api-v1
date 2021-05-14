<?php

namespace Ziletech\Services\Template;

class EmailTemplate {

    private $subject;
    private $content;

    function getSubject() {
        return $this->subject;
    }

    function getContent() {
        return $this->content;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

    function setContent($content) {
        $this->content = $content;
    }

}
