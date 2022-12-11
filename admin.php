<?php

include ("include/dbconnection.php");

$stmt = $stmtfind = $category_tl = null;

$stmtfind = $dbh->prepare("SELECT ez.id, ez.drive_lic_path, ez.veh_img_path, ez.navi_idcard_path, ez.ship_img_path, " 
. "ez.id_img_path, ez.p_name, ez.team_name, ez.p_member_1, ez.p_member_2, ez.p_member_3, ez.p_member_4, k.category "
. "FROM ezexpress ez join category k on ez.category_id = k.id");
       
    $stmtfind->execute();
    
session_start();
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>EZ Express Event Register</title>
        <?php include_once('include/head.php'); ?>
        <style>
            div.hidden{
                   display: none;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.js"></script>
    </head>

    <body>

        <?php include_once('include/navbar.php'); ?>
            
        </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="accordion">
                    <br></br>
                    <div class="card mb-1">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <table id="viewalldata">
                                        <thead>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>Event Type</th>
                                                <th>Team Name</th>
                                                <th>Member 1</th>
                                                <th>Member 2</th>
                                                <th>Member 3</th>
                                                <th>Member 4</th>
                                                <th>ID Card</th>
                                                <th>Vehicle Image</th>
                                                <th>Ship Image</th>
                                                <th>Driving License</th>
                                                <th>Navigator ID Card</th>
                                            </tr>
                                    </thead>
                        <?php
                       
                       
                        while ($row = $stmtfind->fetch()) 
                            {
                                    echo '
                                    
                                        <tr>
                                            <td>' . $row['p_name'] . '</td>
                                            <td>' . $row['category'] . '</td>
                                            <td>' . $row['team_name'] . '</td>
                                            <td>' . $row['p_member_1'] . '</td>
                                            <td>' . $row['p_member_2'] . '</td>
                                            <td>' . $row['p_member_3'] . '</td>
                                            <td>' . $row['p_member_4'] . '</td>
                                            <td><a href="images/'. $row['id_img_path'] .'" target="_blank"><img width="100px" height="100px" src=images/' . $row['id_img_path'] . '></a></td>
                                            <td><a href="images/'. $row['veh_img_path'] .'" target="_blank"><img width="100px" height="100px" src=images/' . $row['veh_img_path'] . '></a></td>
                                            <td><a href="images/'. $row['ship_img_path'] .'" target="_blank"><img width="100px" height="100px" src=images/' . $row['ship_img_path'] . '></a></td>
                                            <td><a href="images/'. $row['drive_lic_path'] .'" target="_blank"><img width="100px" height="100px" src=images/' . $row['drive_lic_path'] . '></a></td>
                                            <td><a href="images/'. $row['navi_idcard_path'] .'" target="_blank"><img width="100px" height="100px" src=images/' . $row['navi_idcard_path'] . '></a></td>
                                        </tr>
                                        </table>
                                        </h5>
                                    </div>
                                </div>';
                            }?>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#viewalldata').DataTable();
            });
        </script>
    </body>
</html> 