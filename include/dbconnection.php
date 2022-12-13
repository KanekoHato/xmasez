<?php 
// DB credentials.
define('DB_HOST','mariadb');
define('DB_USER','kaneko');
define('DB_PASS','M3WQD5qmH6Vzpuu4');
define('DB_NAME','express');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>