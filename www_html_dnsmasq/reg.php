<?php
$tag = explode('?', $_SERVER['REQUEST_URI'])[1];
$ip_seen = $_SERVER['REMOTE_ADDR'];
$ip_forwarded=$_SERVER['HTTP_FORWARDED'];

if ( $ip_seen != $ip_forwarded )
    { $ip = $ip_forwarded; }
else
    { $ip = $ip_seen; }

$pat = '/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/';

if ( preg_match ($pat, $tag) == 1 ) {
    $str = "address=/$tag/$ip";

    $fp = "/etc/dnsmasq.d/$tag.conf";
    $fh = fopen($fp, "w+");

    fwrite($fh, $str);
    fclose($fh);
}


?>
