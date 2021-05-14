<?php

namespace Ziletech\Services\Email;

interface EmailProvider {

    function getSMTPAutoTLS();

    function getSMTPAuth();

    function getSMTPSecure();

    function getHost();

    function getPort();

    function getUsername();

    function getPassword();
}

?>