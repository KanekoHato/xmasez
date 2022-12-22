<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $onserver = getenv('SERVER_MODE') == TRUE ? 1 : 0;
 if ($onserver == 1){
     include($_SERVER['DOCUMENT_ROOT'].'/include/dbconnection.php');
 } 
 else 
 {
     include('./include/dbconnection.php');
 }

$name_id = $_POST['ispaidfind'];

$stmt = $dbh->prepare('DELETE FROM ezexpress WHERE id=?');
$stmt->execute([$name_id]);

echo "<script>location.href='admin.php';</script>";

?>
