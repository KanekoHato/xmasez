 <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 function split_name($name) {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
        return array($first_name, $last_name);
    }

$onserver = 1;

if ($onserver == 1){
    include($_SERVER['DOCUMENT_ROOT'].'/include/dbconnection.php');
} 
else 
{
    include('./include/dbconnection.php');
}

$chkundscr = "_";
$ispaid = "Not Paid";
$idname = "_ID_CARD";
$shipname = "_SHIP";
$vehname = "_VEH";
$naviname = "_NAV_ID";
$drvname = "_DRV_LIC";
$serverdiir = "/images/";
$localdir = "images/";
$response = array(
        "type" => "",
        "message" => ""
    );

$name_full = $_POST['fullname'];
$onteam = $_POST['onteam'];
$teamname = $_POST['teamname'];
$cat = (int)$_POST['event_select'];
$team1 = $_POST['team1'];
$team2 = $_POST['team2'];
$team3 = $_POST['team3'];
$team4 = $_POST['team4'];

if (str_contains($name_full, $chkundscr)) {
        $name_full = $_POST['fullname'];
 } 
 else 
 {
        split_name($name_full);
        $name_full = $first_name . $chkundscr . $last_name;     
 }

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

$idcardsize = $_FILES['idcardpicture']['size'];
$shipimgsize = $_FILES['shippicture']['size'];
$vehimgsize = $_FILES['vehiclepicture']['size'];
$naviimgsize = $_FILES['navigatoridpicture']['size'];
$drvimgsize = $_FILES['drivinglicense']['size'];

$allowTypes = array('png');


$stmt = $dbh->prepare('INSERT INTO ezexpress (ispaid,p_name,team_state,team_name,p_member_1,p_member_2,'
        . 'p_member_3,p_member_4,category_id) VALUES(?,?,?,?,?,?,?,?,?)');

$stmt->execute([$ispaid,$name_full,$onteam,$teamname,$team1,$team2,$team3,$team4,$cat]);

if (isset($_POST["submit"]) && strlen($idcard) > 0){
        $extexplode = explode('.', $idcard);
        $ext = end($extexplode); // upload file ext
        $name = $idcom . '.' . $ext; // Rename image file name
        $stmt = $dbh->prepare('UPDATE ezexpress SET id_img_path=? WHERE p_name=?');
        $stmt->execute([$name,$name_full]);
        if($onserver == 1)
        {
                $path = $_SERVER['DOCUMENT_ROOT'].$serverdiir. $name;
        } 
        else 
        {
                $path = $localdir. $name;
        }
        if (in_array($ext, $allowTypes)) 
        {
                if (move_uploaded_file($_FILES["idcardpicture"]["tmp_name"], $path)) 
                {
                        $response = array(
                                "type" => "success",
                                "message" => "File ".$name." has been uploaded."
                        );
                }else if($idcardsize > 2000000){
                        $response = array(
                                "type" => "danger",
                                "message" => "Failed to upload ".$name. " files larger than 2MB."
                        );
                } else {
                        $response = array(
                                "type" => "danger",
                                "message" => "Failed to upload ".$name. " files."
                        );
                }
        } else {
                $response = array(
                        "type" => "danger",
                        "message" => "Sorry, only JPG, are allowed to upload."
                );
        }
        
        //var_dump($name);
}else{
        $response = array(
                "type" => "warning",
                "message" => "No Files, Select File To Upload."
        );
    }

if (isset($_POST["submit"]) && strlen($shipimg) > 0){
        $extexplode = explode('.', $shipimg);
        $ext = end($extexplode); // upload file ext
        $name = $shipcom . '.' . $ext; // 
        $stmt = $dbh->prepare('UPDATE ezexpress SET ship_img_path=? WHERE p_name=?');
        $stmt->execute([$name,$name_full]);
        if($onserver == 1)
        {
                $path = $_SERVER['DOCUMENT_ROOT'].$serverdiir. $name;
        } 
        else 
        {
                $path = $localdir. $name;
        }
        if (in_array($ext, $allowTypes)) 
        {
                if (move_uploaded_file($_FILES["shippicture"]["tmp_name"], $path)) 
                {
                        $response = array(
                                "type" => "success",
                                "message" => "File ".$name." has been uploaded."
                        );
                }else if($shipimgsize > 2000000){
                        $response = array(
                                "type" => "danger",
                                "message" => "Failed to upload ".$name. " files larger than 2MB."
                        );
                } else {
                        $response = array(
                                "type" => "danger",
                                "message" => "Failed to upload ".$name. " files."
                        );
                }
        } else {
                $response = array(
                        "type" => "danger",
                        "message" => "Sorry, only JPG, are allowed to upload."
                );
        }
        
        //var_dump($name);
        
}else{
        $response = array(
                "type" => "warning",
                "message" => "No Files, Select File To Upload."
        );
    }

if (isset($_POST["submit"]) && strlen($vehimg) > 0){
        $extexplode = explode('.', $vehimg);
        $ext = end($extexplode); // upload file ext
        $name = $vehcom . '.' . $ext; // 
        $stmt = $dbh->prepare('UPDATE ezexpress SET veh_img_path=? WHERE p_name=?');
        $stmt->execute([$name,$name_full]);
        if($onserver == 1)
        {
                $path = $_SERVER['DOCUMENT_ROOT'].$serverdiir. $name;
        } 
        else 
        {
                $path = $localdir. $name;
        }
        if (in_array($ext, $allowTypes)) 
        {
                if (move_uploaded_file($_FILES["vehiclepicture"]["tmp_name"], $path)) 
                {
                        $response = array(
                                "type" => "success",
                                "message" => "File ".$name." has been uploaded."
                        );
                }else if($vehimgsize > 2000000){
                        $response = array(
                                "type" => "danger",
                                "message" => "Failed to upload ".$name. " files larger than 2MB."
                        );
                } else {
                        $response = array(
                                "type" => "danger",
                                "message" => "Failed to upload ".$name. " files."
                        );
                }
        } else {
                $response = array(
                        "type" => "danger",
                        "message" => "Sorry, only JPG, are allowed to upload."
                );
        }
        //var_dump($name);

}else{
        $response = array(
                "type" => "warning",
                "message" => "No Files, Select File To Upload."
        );
    }

if (isset($_POST["submit"]) && strlen($naviimg) > 0){
        $extexplode = explode('.', $naviimg);
        $ext = end($extexplode); // upload file ext
        $name = $navcom . '.' . $ext; // 
        $stmt = $dbh->prepare('UPDATE ezexpress SET navi_idcard_path=? WHERE p_name=?');
        $stmt->execute([$name,$name_full]);
        if($onserver == 1)
        {
                $path = $_SERVER['DOCUMENT_ROOT'].$serverdiir. $name;
        } 
        else 
        {
                $path = $localdir. $name;
        }
        if (in_array($ext, $allowTypes)) 
        {
                if (move_uploaded_file($_FILES["navigatoridpicture"]["tmp_name"], $path)) 
                {
                        $response = array(
                                "type" => "success",
                                "message" => "File ".$name." has been uploaded."
                        );
                }else if($naviimgsize > 2000000){
                        $response = array(
                                "type" => "danger",
                                "message" => "Failed to upload ".$name. " files larger than 2MB."
                        );
                } else {
                        $response = array(
                                "type" => "danger",
                                "message" => "Failed to upload ".$name. " files."
                        );
                }
        } else {
                $response = array(
                        "type" => "danger",
                        "message" => "Sorry, only JPG, are allowed to upload."
                );
        }
        //var_dump($name);

}else{
        $response = array(
                "type" => "warning",
                "message" => "No Files, Select File To Upload."
        );
    }

if (isset($_POST["submit"]) && strlen($drvimg) > 0){
        $extexplode = explode('.', $drvimg);
        $ext = end($extexplode); // upload file ext
        $name = $drvcom . '.' . $ext; //
        $stmt = $dbh->prepare('UPDATE ezexpress SET drive_lic_path=? WHERE p_name=?');
        $stmt->execute([$name,$name_full]);
        if($onserver == 1)
        {
                $path = $_SERVER['DOCUMENT_ROOT'].$serverdiir. $name;
        } 
        else 
        {
                $path = $localdir. $name;
        }
        if (in_array($ext, $allowTypes)) 
        {
                 if (move_uploaded_file($_FILES["drivinglicense"]["tmp_name"], $path)) 
                 {
                        $response = array(
                                "type" => "success",
                                "message" => "File ".$name." has been uploaded."
                        );
                }else if($drvimgsize > 2000000){
                        $response = array(
                                "type" => "danger",
                                "message" => "Failed to upload ".$name. " files larger than 2MB."
                        );
                } else {
                        $response = array(
                                "type" => "danger",
                                "message" => "Failed to upload ".$name. " files."
                        );
                }
        } else {
                $response = array(
                        "type" => "danger",
                        "message" => "Sorry, only JPG, are allowed to upload."
                );
        }
        
}else{
        $response = array(
                "type" => "warning",
                "message" => "No Files, Select File To Upload."
        );
    }

    $_SESSION['error'] = $response['type'];
    $_SESSION['message'] = $response['message'];
    echo "<script>location.href='index.php';</script>";


?>
