<?php
$tag = explode('?', $_SERVER['REQUEST_URI'])[1];
$ip = $_SERVER['REMOTE_ADDR'];

$pat = '/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/';

if ( preg_match ($pat, $tag) == 1 ) {
    $str = "address=/$tag/$ip";

    $fp = "/etc/dnsmasq.d/$tag.conf";
    $fh = fopen($fp, "w+");

    fwrite($fh, $str);
    fclose($fh);
}


?>