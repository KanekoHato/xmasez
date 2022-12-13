 <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once ('include/dbconnection.php');

$ispaid = "Not Paid";
$idname = "_ID_CARD";
$shipname = "_SHIP";
$vehname = "_VEH";
$naviname = "_NAV_ID";
$drvname = "_DRV_LIC";

$name_full = $_POST['fullname'];
$onteam = $_POST['onteam'];
$teamname = $_POST['teamname'];
$cat = (int)$_POST['event_select'];
$team1 = $_POST['team1'];
$team2 = $_POST['team2'];
$team3 = $_POST['team3'];
$team4 = $_POST['team4'];


$idcom = $name_full . $idname; 
$shipcom = $name_full . $shipname;
$vehcom = $name_full . $vehname;
$navcom =  $name_full . $naviname;
$drvcom = $name_full . $drvname;

$idcard = $_FILES['idcardpicture']['name'];
$shipimg = $_FILES['shippicture']['name'];
$vehimg = $_FILES['vehiclepicture']['name'];
$naviimg = $_FILES['navigatoridpicture']['name'];
$drvimg = $_FILES['drivinglicense']['name'];


//echo 'Before Input Data To DB : ';var_dump($dbh);
$stmt = $dbh->prepare('INSERT INTO ezexpress (ispaid,p_name,team_state,team_name,p_member_1,p_member_2,'
        . 'p_member_3,p_member_4,category_id) VALUES(?,?,?,?,?,?,?,?,?)');
//echo 'After Preparing DB Query : '; var_dump($stmt);
$stmt->execute([$ispaid,$name_full,$onteam,$teamname,$team1,$team2,$team3,$team4,$cat]);
//echo 'After Executing DB : '; var_dump($stmt);

if (strlen($idcard) > 0){
        $ext = end(explode('.', $idcard)); // upload file ext
        $name = $idcom . '.' . $ext; // Rename image file name
        //var_dump($name);
        $stmt = $dbh->prepare('UPDATE ezexpress SET id_img_path=? WHERE p_name=?');
        $stmt->execute([$name,$name_full]);
        $path = "images/". $name;
        move_uploaded_file($_FILES["idcardpicture"]["tmp_name"], $path);
}

if (strlen($shipimg) > 0){
        $ext = end(explode('.', $shipimg)); 
        $name = $shipcom . '.' . $ext; // 
        //var_dump($name);
        $stmt = $dbh->prepare('UPDATE ezexpress SET ship_img_path=? WHERE p_name=?');
        $stmt->execute([$name,$name_full]);
        $path = "images/". $name;
        move_uploaded_file($_FILES["shippicture"]["tmp_name"], $path);
}

if (strlen($vehimg) > 0){
        
        $ext = end(explode('.', $vehimg)); 
        $name = $vehcom . '.' . $ext; // 
        //var_dump($name);
        $stmt = $dbh->prepare('UPDATE ezexpress SET veh_img_path=? WHERE p_name=?');
        $stmt->execute([$name,$name_full]);
        $path = "images/". $name;
        move_uploaded_file($_FILES["vehiclepicture"]["tmp_name"], $path);
}

if (strlen($naviimg) > 0){
        $ext = end(explode('.', $naviimg));
        $name = $navcom . '.' . $ext; // 
        //var_dump($name);
        $stmt = $dbh->prepare('UPDATE ezexpress SET navi_idcard_path=? WHERE p_name=?');
        $stmt->execute([$name,$name_full]);
        $path = "images/". $name;
        move_uploaded_file($_FILES["navigatoridpicture"]["tmp_name"], $path);
}

if (strlen($drvimg) > 0){
        $ext = end(explode('.', $drvimg));  
        $name = $drvcom . '.' . $ext; //
        //var_dump($name);
        $stmt = $dbh->prepare('UPDATE ezexpress SET drive_lic_path=? WHERE p_name=?');
        $stmt->execute([$name,$name_full]);
        $path = "images/". $name;
        move_uploaded_file($_FILES["drivinglicense"]["tmp_name"], $path);
}
//echo "<script>location.href='index.php';</script>";

?>
