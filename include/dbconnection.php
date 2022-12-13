<?php 
// DB credentials.
if (isset($_SERVER['DB_HOST'])) {
  define('DB_HOST',$_SERVER['DB_HOST']);
} else {
  define('DB_HOST','127.0.0.1');
}

if (isset($_SERVER['DB_PORT'])) {
  define('DB_PORT',$_SERVER['DB_PORT']);
} else {
  define('DB_PORT','3306');
}

if (isset($_SERVER['DB_USERNAME'])) {
  define('DB_USER',$_SERVER['DB_USERNAME']);
} else {
  define('DB_USER','kaneko');
}

if (isset($_SERVER['DB_PASSWORD'])) {
  define('DB_PASS',$_SERVER['DB_PASSWORD']);
} else {
  define('DB_PASS','M3WQD5qmH6Vzpuu4');
}

if (isset($_SERVER['DB_NAME'])) {
  define('DB_NAME',$_SERVER['DB_NAME']);
} else {
  define('DB_NAME','express');
}

// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>