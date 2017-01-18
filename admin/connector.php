<?php
$db_host	  = 'mysql.zzz.com.ua';
$db_user	  = 'ks';
$db_pass      = '123456';
$db_database  = 'jene_romanukha';

$bd = mysql_connect ($db_host,$db_user,$db_pass) or die(mysql_error());
mysql_select_db ($db_database,$bd)  or die(mysql_error());
mysql_query("set names utf8");
?>
