<?php
$dbhost = "remotemysql.com:3306";
$dbuser = "nlv6D3f2DK";
$dbpass = "ob0gvyfXhv";
$db = "nlv6D3f2DK";
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);
