<?php

/* 
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/
$onserver = getenv('SERVER_MODE') == TRUE ? 1 : 0;
function split_name($name)
{
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim(preg_replace('#' . preg_quote($last_name, '#') . '#', '', $name));

        return array(
                'first' => $first_name,
                'last' => $last_name,
        );
}


session_start();

$sess_csrf_token = isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : null;
$_csrf_token = $_POST['_csrf'];

if (!$sess_csrf_token || $_csrf_token != $sess_csrf_token) {
        $_SESSION['error'] = array(
                array (
                        "type" => "danger",
                        "message" => "Invalid request",
                )
        );
        echo "<script>location.href='index.php';</script>";
        return;
}

if ($onserver == 1) {
        include($_SERVER['DOCUMENT_ROOT'] . '/include/dbconnection.php');
} else {
        include('./include/dbconnection.php');
}

$chkundscr = "_";
$ispaid = "Not Paid";
$idname = "_ID_CARD";
$drvname = "_DRV_LIC";
$serverdiir = "/images/";
$localdir = "images/";
$response = array();

$name_full = $_POST['fullname'];
$onteam = $_POST['onteam'];
$teamname = $_POST['teamname'];
$cat = (int) $_POST['event_select'];
$team1 = $_POST['team1'];
$team2 = $_POST['team2'];
$team3 = $_POST['team3'];

if (str_contains($team1, $chkundscr)) {
        $team1 = $_POST['team1'];
} else {
        $splitted_name = split_name($team1);
        $team1 = $splitted_name['first'] . $chkundscr . $splitted_name['last'];
}

if (str_contains($team2, $chkundscr)) {
        $team2 = $_POST['team2'];
} else {
        $splitted_name = split_name($team2);
        $team2 = $splitted_name['first'] . $chkundscr . $splitted_name['last'];
}

if (str_contains($team3, $chkundscr)) {
        $team3 = $_POST['team3'];
} else {
        $splitted_name = split_name($team3);
        $team3 = $splitted_name['first'] . $chkundscr . $splitted_name['last'];
}

if (str_contains($name_full, $chkundscr)) {
        $name_full = $_POST['fullname'];
} else {
        $splitted_name = split_name($name_full);
        $name_full = $splitted_name['first'] . $chkundscr . $splitted_name['last'];
}

$idcom = $name_full . $idname;
$drvcom = $name_full . $drvname;

$idcard = $_FILES['idcardpicture']['name'];
$drvimg = $_FILES['drivinglicense']['name'];
$idcardsize = $_FILES['idcardpicture']['size'];
$drvimgsize = $_FILES['drivinglicense']['size'];

$allowTypes = array('png');


$stmt = $dbh->prepare('INSERT INTO ezexpress (ispaid,p_name,team_state,team_name,p_member_1,p_member_2,'
        . 'p_member_3,category_id) VALUES(?,?,?,?,?,?,?,?)');

$stmt->execute([$ispaid, $name_full, $onteam, $teamname, $team1, $team2, $team3, $cat]);

if (isset($_POST["submit"]) && strlen($idcard) > 0) {
        $extexplode = explode('.', $idcard);
        $ext = end($extexplode); // upload file ext
        $name = $idcom . '.' . $ext; // Rename image file name
        $stmt = $dbh->prepare('UPDATE ezexpress SET id_img_path=? WHERE p_name=?');
        $stmt->execute([$name, $name_full]);
        if ($onserver == 1) {
                $path = $_SERVER['DOCUMENT_ROOT'] . $serverdiir . $name;
        } else {
                $path = $localdir . $name;
        }
        if (in_array($ext, $allowTypes)) {
                if (move_uploaded_file($_FILES["idcardpicture"]["tmp_name"], $path)) {
                        array_push($response,array(
                                "type" => "success",
                                "message" => "File " . $name . " has been uploaded."
                                )
                        );
                } else if ($drvimgsize > 2000000) {
                                array_push($response,array(
                                        "type" => "danger",
                                        "message" => "Failed to upload " . $name . " files larger than 2MB."
                                )
                        );
                } else {
                        array_push($response,array(
                                "type" => "danger",
                                "message" => "Failed to upload " . $name . " files."
                        ));
                }
        } else {
                
                array_push($response,array(
                        "type" => "danger",
                        "message" => "Failed to upload " . $name . " files."
                ));
        }

} else {
        array_push($response, array(
                "type" => "warning",
                "message" => "No Files, Select File To Upload.")
        );        
}

if (isset($_POST["submit"]) && strlen($drvimg) > 0) {
        $extexplode = explode('.', $drvimg);
        $ext = end($extexplode); // upload file ext
        $name = $drvcom . '.' . $ext; //
        $stmt = $dbh->prepare('UPDATE ezexpress SET drive_lic_path=? WHERE p_name=?');
        $stmt->execute([$name, $name_full]);
        if ($onserver == 1) {
                $path = $_SERVER['DOCUMENT_ROOT'] . $serverdiir . $name;
        } else {
                $path = $localdir . $name;
        }
        if (in_array($ext, $allowTypes)) {
                if (move_uploaded_file($_FILES["drivinglicense"]["tmp_name"], $path)) {
                        array_push($response,array(
                                "type" => "success",
                                "message" => "File " . $name . " has been uploaded."
                                )
                        );
                } else if ($drvimgsize > 2000000) {
                                array_push($response,array(
                                        "type" => "danger",
                                        "message" => "Failed to upload " . $name . " files larger than 2MB."
                                )
                        );
                } else {
                        array_push($response,array(
                                "type" => "danger",
                                "message" => "Failed to upload " . $name . " files."
                        ));
                }
        } else {
                
                array_push($response,array(
                        "type" => "danger",
                        "message" => "Failed to upload " . $name . " files."
                ));
        }

} else {
        array_push($response, array(
                "type" => "warning",
                "message" => "No Files, Select File To Upload.")
        );        
}

$_SESSION['error'] = $response;
$_SESSION['csrf_token'] = null;
echo "<script>location.href='index.php';</script>";


?>
