<?php 
// DB credentials.
if (isset($_ENV[DB_HOST])) {
  define('DB_HOST',$_ENV[DB_HOST]);
} else {
  define('DB_HOST','127.0.0.1');
}

if (isset($_ENV[DB_USERNAME])) {
  define('DB_USER',$_ENV[DB_USERNAME]);
} else {
  define('DB_USER','kaneko');
}

if (isset($_ENV[DB_PASSWORD])) {
  define('DB_PASS',$_ENV[DB_PASSWORD]);
} else {
  define('DB_PASS','M3WQD5qmH6Vzpuu4');
}

if (isset($_ENV[DB_NAME])) {
  define('DB_NAME',$_ENV[DB_NAME]);
} else {
  define('DB_NAME','express');
}

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