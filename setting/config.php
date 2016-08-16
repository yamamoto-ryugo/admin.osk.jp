<?php

/* DB接続 */
$host = "localhost";
$dbname = "osk";
$user = "root";
$pass = "ryugo1120";

$dbh = new PDO('mysql:host='.$host.';dbname='.$dbname.';charaset=utf8', $user, $pass);



define('PASSWORD_KEY', 'ryugo1120');

error_reporting(E_ALL & ~E_NOTICE);
