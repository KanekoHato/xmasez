<?php 
// DB credentials.
if (getenv('DB_HOST')) {
  define('DB_HOST',getenv('DB_HOST'));
} else {
  define('DB_HOST','127.0.0.1');
}

if (getenv('DB_PORT')) {
  define('DB_PORT',getenv('DB_PORT'));
} else {
  define('DB_PORT','3306');
}

if (getenv('DB_USERNAME')) {
  define('DB_USER',getenv('DB_USERNAME'));
} else {
  define('DB_USER','kaneko');
}

if (getenv('DB_PASSWORD')) {
  define('DB_PASS',getenv('DB_PASSWORD'));
} else {
  define('DB_PASS','M3WQD5qmH6Vzpuu4');
}

if (getenv('DB_NAME')) {
  define('DB_NAME',getenv('DB_NAME'));
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