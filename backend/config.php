<?php
define("DB_HOST","localhost");
define("DB_NAME","twitter");
define("DB_USER","tweety");
define("DB_PASS","tweety");

$public_end= strpos($_SERVER['SCRIPT_NAME'], "/frontend")+8;
$doc_root= substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT",$doc_root);


?>