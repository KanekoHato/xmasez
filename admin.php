<?php

$onserver = getenv('SERVER_MODE') == TRUE ? 1 : 0;
if ($onserver == 1){
    include($_SERVER['DOCUMENT_ROOT'].'/include/dbconnection.php');
} 
else 
{
    include('./include/dbconnection.php');
}

$stmt = $stmtfind = $category_tl = null;

$stmtfind = $dbh->prepare("SELECT ez.id, ez.drive_lic_path, ez.ispaid, " 
. "ez.id_img_path, ez.p_name, ez.team_name, ez.p_member_1, ez.p_member_2, ez.p_member_3, ez.p_member_4, ez.qualifier, k.category "
. "FROM ezexpress ez join category k on ez.category_id = k.id");
       
    $stmtfind->execute();
    
session_start();
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>EZ Express Event Register</title>
        <?php         
        if ($onserver == 1){
            include_once($_SERVER['DOCUMENT_ROOT'].'/include/head.php');
        } 
        else 
        {
            include_once('./include/head.php');
        } ?>

        <style>
            div.hidden{
                display: none;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.js"></script>
    </head>

    <body>

        <?php 
        if ($onserver == 1) 
        {
            include_once($_SERVER['DOCUMENT_ROOT'].'/include/navbar.php'); 
        }
        else
        {
            include_once('./include/navbar.php');
        }
        ?>
            
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
                                                <th>Is Paid</th>
                                                <th>Qualifier</th>
                                                <th>ID Card</th>
                                                <th>Drv Lic</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        <?php

                        while ($row = $stmtfind->fetch()) 
                            {
                                $vehimgfull = $idimgfull = $shipimgfull = $drivelicimgfull = $navididimgfull = '';

                                if($row['id_img_path'] > 0){
                                    $idimgfull = '<img width="50px" height="50px" src=images/' . $row['id_img_path'] . ' onerror="imgError(this);">';                 
                                }
                                if($row['drive_lic_path'] > 0){
                                    $drivelicimgfull = '<img width="50px" height="50px"  src=images/' . $row['drive_lic_path'] . ' onerror="imgError(this);">';                 
                                }
                                    echo '
                                    
                                                <tr>
                                                    <td>' . $row['p_name'] . '</td>
                                                    <td>' . $row['category'] . '</td>
                                                    <td>' . $row['team_name'] . '</td>
                                                    <td>' . $row['p_member_1'] . '</td>
                                                    <td>' . $row['p_member_2'] . '</td>
                                                    <td>' . $row['p_member_3'] . '</td>
                                                    <td>' . $row['ispaid'] . '</td>
                                                    <td>' . $row['qualifier'] . '</td>
                                                    <td><a href="images/'. $row['id_img_path'] .'" target="_blank">' . $idimgfull . '</a></td>
                                                    <td><a href="images/'. $row['drive_lic_path'] .'" target="_blank">' . $drivelicimgfull . '</a></td>
                                                    <td>
                                                        <form action="ispaid.php" method="POST">
                                                            <button name="ispaidfind" class="btn btn-primary" type="submit" value="' . $row['id'] . '">PAID</button>
                                                        </form>
                                                        <form action="removeparticipant.php" method="POST">
                                                            <button name="ispaidfind" class="btn btn-danger" type="submit" value="' . $row['id'] . '">DELETE</button>
                                                        </form>
                                                        <form action="qualifierupdate.php" method="POST">
                                                            <select class="btn btn-primary" id="qualifierupdate" name="qualifier"
                                                            class="form-select">
                                                                <option value="Qualified">Qualified</option>
                                                                <option value="Disqualified">Disqualified</option>
                                                                <option value="Eliminated">Eliminated</option>
                                                                <option value="Semi_Final">Semi Final</option>
                                                                <option value="Final">Final</option>
                                                                <option value="Winner">Winner</option>
                                                            </select>
                                                            <button name="ispaidfind" class="btn btn-danger" type="submit" value="' . $row['id'] . '">Update Qualifier</button>
                                                        </form>
                                                </td>
                                                </tr>
                                            ';
                            }?>
                                                </tbody>
                                            </table>
                                        </h5>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
                function imgError(image) {
                    image.onerror = "";
                    image.src = "../noimg.png";
                    return true;
                }
                $(document).ready(function () {
                    $('#viewalldata').DataTable();
                });
        </script>
    </body>
</html> 