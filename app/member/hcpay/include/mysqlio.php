<?php
unset($mysqlio);
$mysqlio = new MySQLi("localhost","root","1qaz2wsx","other_db");
$mysqlio->query("set names utf8");

?>