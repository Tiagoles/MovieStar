<?php

$dbname = 'moviestar';
$dbuser= 'root';
$dbhost = 'localhost';
$dbpass = '';
$conn = new PDO("mysql:dbname=$dbname;host=$dbhost", $dbuser, $dbpass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

