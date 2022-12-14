<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $onserver = 1;
 if ($onserver == 1){
     include($_SERVER['DOCUMENT_ROOT'].'/include/dbconnection.php');
 } 
 else 
 {
     include('./include/dbconnection.php');
 }

$name_full = $_POST['ispaidfind'];
$ispaid = "Paid";

$stmt = $dbh->prepare('UPDATE ezexpress SET ispaid=? WHERE id=?');
$stmt->execute([$ispaid,$name_full]);

echo "<script>location.href='admin.php';</script>";

?>
