<?php
function generate_csrf() {
    return md5(uniqid(mt_rand(), true));
}

$onserver = getenv('SERVER_MODE') == TRUE ? 1 : 0;
if ($onserver == 1){
    include($_SERVER['DOCUMENT_ROOT'].'/include/dbconnection.php');
} 
else 
{
    include('./include/dbconnection.php');
}



$stmt = $stmtfind = null;


if (isset($_GET['find'])) {

    $search = '%' . $_GET['find'] . '%';
    $search_like = $search;
    $stmtfind = $dbh->prepare("SELECT ez.id, ez.drive_lic_path, ez.ispaid, ez.veh_img_path, ez.navi_idcard_path, ez.ship_img_path, "
        . "ez.id_img_path, ez.p_name, ez.team_name, ez.p_member_1, ez.p_member_2, ez.p_member_3, ez.p_member_4, k.category "
        . "FROM ezexpress ez join category k on ez.category_id = k.id WHERE (p_name LIKE ?)");

    $stmtfind->execute([$search_like]);
}

session_start();
$error = count($_SESSION) == 0 ? array() : $_SESSION['error'];
$csrf_token = generate_csrf();
$_SESSION['csrf_token'] = $csrf_token;

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
        }
        ?>
        
        <style>
            .hidden {
                display: none;
            }
            .collapsible {
                background-color: #777;
                color: white;
                cursor: pointer;
                padding: 18px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 15px;
            }

            .active, .collapsible:hover {
                background-color: #555;
            }

            .content {
                padding: 0 18px;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.2s ease-out;
                background-color: #f1f1f1;
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

        <?php
            if(!empty($error)) {
        ?>
        <div class="toast" data-autohide="false">
        <div class="toast-header">
            <strong class="mr-auto text-primary"><?php echo $error['type']; ?></strong>
            <small class="text-muted">Theres an <?php echo $error['type']; ?></small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
            <div class="toast-body">
                <?php echo $error['message']; ?>
            </div>
        </div>
        <?php } ?>

        <div class="container pt-5">
            <div class="row mb-3">
                <div class="col-md-12">
                    <form action="index.php" method="GET">
                        <div class="input-group">
                            <label for="find"></label>
                            <input type="text" name="find" placeholder="Party Leader / Your Name Ex:(Mitsuko_Amai)" class="form-control" size="20" required autofocus>
                            <button type="submit" class="btn btn-primary">Find</button>



                        </div>
                    </form>
                </div>
                 <div class="row mb-2">
                
            </div>
                </form>
            </div>
           
            <div class="container-fluid">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eventregister">
                    Register To The Event
                </button>
                
            </div>
            
        </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="accordion">
                            <br></br>
                                <div class="card mb-1">
                                    <div class="card-header">
                                        <h5 class="mb-0">
                                        <button class="collapsible">Open Data</button>
                                            <div class="content">
                                            <table id="viewmyregdata">
                                                <thead>
                                                    <tr>
                                                        <th>Full Name</th>
                                                        <th>Event Type</th>
                                                        <th>Team Name</th>
                                                        <th>Member 1</th>
                                                        <th>Member 2</th>
                                                        <th>Member 3</th>
                                                        <th>Member 4</th>
                                                        <th>Paid Status</th>
                                                        <th>ID Card</th>
                                                        <th>Vehicle Image</th>
                                                        <th>Ship Image</th>
                                                        <th>Driv Lic</th>
                                                        <th>NavigID Card</th>
                                                    </tr>
                                            </thead>
                                <?php
                                if (isset($_GET['find'])) {
                                    while ($row = $stmtfind->fetch()) {

                                        $paidplayer = $vehimgfull = $idimgfull = $shipimgfull = $drivelicimgfull = $navididimgfull = '';
                                        $ispaidinfo = $row['ispaid'];

                                        if (isset($ispaidinfo)) {
                                            $paidplayer = '
                                            <div class="alert alert-primary" role="alert">
                                                Registration Fee Is : ' . $row['ispaid'] . '
                                                </div>
                                            </div>';
                                        }

                                        if ($row['veh_img_path'] > 0) {
                                            $vehimgfull = '<img width="50px" height="50px" src=images/' . $row['veh_img_path'] . '>';
                                        }
                                        if ($row['ship_img_path'] > 0) {
                                            $shipimgfull = '<img width="50px" height="50px" src=images/' . $row['ship_img_path'] . '>';
                                        }
                                        if ($row['id_img_path'] > 0) {
                                            $idimgfull = '<img width="50px" height="50px" src=images/' . $row['id_img_path'] . '>';
                                        }
                                        if ($row['drive_lic_path'] > 0) {
                                            $drivelicimgfull = '<img width="50px" height="50px" src=images/' . $row['drive_lic_path'] . '>';
                                        }
                                        if ($row['navi_idcard_path'] > 0) {
                                            $navididimgfull = '<img width="50px" height="50px" src=images/' . $row['navi_idcard_path'] . '>';
                                        }


                                        echo '
                                                
                                                    <tr>
                                                        <td>' . $row['p_name'] . '</td>
                                                        <td>' . $row['category'] . '</td>
                                                        <td>' . $row['team_name'] . '</td>
                                                        <td>' . $row['p_member_1'] . '</td>
                                                        <td>' . $row['p_member_2'] . '</td>
                                                        <td>' . $row['p_member_3'] . '</td>
                                                        <td>' . $row['p_member_4'] . '</td>
                                                        <td>'. $paidplayer .'</td>
                                                        <td><a href="images/' . $row['id_img_path'] . '" target="_blank">' . $idimgfull . '</a></td>
                                                        <td><a href="images/' . $row['veh_img_path'] . '" target="_blank">' . $vehimgfull . '</a></td>
                                                        <td><a href="images/' . $row['ship_img_path'] . '" target="_blank">' . $shipimgfull . '</a></td>
                                                        <td><a href="images/' . $row['drive_lic_path'] . '" target="_blank">' . $drivelicimgfull . '</a></td>
                                                        <td><a href="images/' . $row['navi_idcard_path'] . '" target="_blank">' . $navididimgfull . '</a></td>
                                                    </tr>
                                                    ';
                                    }

                                } else { ?>
                                                        
                                <div class="row">
                                </div>   
                                    <?php }
                                    ?>
                                                        </table>
                                                        </div>
                                                    </h5>
                                                </div>
                                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                                </div>

            <div class="modal fade" id="eventregister" tabindex="-1" role="dialog" aria-labelledby="eventregisterlabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventregister">Register To The Event</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="registerevent.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_csrf" value="<?= $csrf_token ?>" />
                            <div class="modal-body">

                                <div class="form-group">
                                    <div>
                                        <label for="fullname">Full Name / Party Leader Name</label>
                                        <input type="text" placeholder="Kaneko Hato" name="fullname" class="form-control" required autofocus>
                                    </div>
                                    <div>
                                        <select class="btn btn-primary" id="eventselect" name="event_select" class="form-select">
                                            <?php
                                            $stmt = $dbh->query('SELECT * FROM category');
                                            while ($row = $stmt->fetch()) {
                                                echo '<option value="' . $row['id'] . '">' . $row['category'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div>
                                        <span for="playeridcard">Upload Your ID Picture Here</span>
                                        <input class="btn btn-primary" type="file" id="playeridcard" name="idcardpicture" value="" />
                                    </div>

                                    <div>
                                        <label for="drivinglic">Upload Your Driving License Picture Here</label>
                                        <input class="btn btn-primary" type="file" id="drivinglic" name="drivinglicense" value="" />
                                    <div>
                                    
                                    <div>
                                        <select class="btn btn-primary" id="teamselect"  name="onteam" class="form-select">
                                            <option value="0" selected>Are You On Team?</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>
                                    
                                            <div id="showteam" class="hidden">
                                                <label for="teamname">Team Name</label>
                                                <input placeholder="EZ Express" type="text" name="teamname" class="form-control">

                                                
                                                    <label for="team1">Team Member 1 / Navigator / Fish Helper</label>
                                                    <input placeholder="Ensley_Flameheart" type="text" name="team1" class="form-control">
                                                
                                                    <div id="hideteamfishandrally" class="hidden">
                                                    <label for="team2">Team Member 2</label>
                                                    <input placeholder="Ensley_Naomi" type="text" name="team2" class="form-control">

                                                    <label for="team3">Team Member 3</label>
                                                    <input placeholder="Ensley_Naoko" type="text" name="team3" class="form-control">

                                                    <label for="team4">Team Member 4</label>
                                                    <input placeholder="Ensley_Amai" type="text" name="team4" class="form-control">
                                                </div>
                                            </div>
                                                <div id="hideforrallyandfish" class="hidden">
                                                    <div id="showship" >
                                                        <label for="shippic">Upload Ship Picture Here</label>
                                                        <input class="btn btn-primary" type="file" id="shippic" name="shippicture" value="" />
                                                    </div>
                                                    
                                                    <div id="showrally" class="hidden">
                                                        <label for="vehpic">Upload Vehicle Picture Here</label>
                                                        <input class="btn btn-primary" type="file" id="vehpic" name="vehiclepicture" value="" />
                                                            

                                                        <label for="navigatorid">Upload Your Navigator ID Here</label>
                                                        <input class="btn btn-primary" type="file" id="navigatorid" name="navigatoridpicture" value="" />
                                                    </div>
                                                <div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="submit" value="Upload" class="btn btn-primary">Sent</button>
                            </div>
                        </form>   
                    </div>
                </div>
        <script>
                var event = document.getElementById('eventselect');
                var rally = document.getElementById('showrally');
                var fishing = document.getElementById('showship');
                var paintball = document.getElementById('hideforrallyandfish');
                var hideteamfishrally = document.getElementById('hideteamfishandrally');
                //var hideall = document.getElementById('hideall');
               
                
                var onteam = document.getElementById('teamselect');
                var team = document.getElementById('showteam');
                
                rally.classList.add('hidden');
                fishing.classList.add('hidden');
                paintball.classList.add('hidden');
                //hideall.classList.add('hidden');
                team.classList.add('hidden');
                hideteamfishrally.classList.add('hidden');

                event.addEventListener('change', function() {
                    rally.classList.add('hidden');
                    fishing.classList.add('hidden');
                    paintball.classList.add('hidden');
                    //hideall.classList.add('hidden');
                    hideteamfishrally.classList.add('hidden');
                    
                    if(event.value === '1'){
                        paintball.classList.add('hidden');
                        hideteamfishrally.classList.remove('hidden');
                    }else if(event.value === '2'){
                        paintball.classList.remove('hidden');
                        rally.classList.remove('hidden');
                    }else if(event.value === '3'){
                        paintball.classList.remove('hidden');
                        rally.classList.remove('hidden');
                    }else if(event.value === '4'){
                        paintball.classList.remove('hidden');
                        fishing.classList.remove('hidden');
                    }
                });


                onteam.addEventListener('change', function() {
                    team.classList.add('hidden');
                
                    if(onteam.value === '1'){
                        team.classList.remove('hidden');
                    }
                });

                $(document).ready(function () {
                    $('#viewmyregdata').DataTable();
                });

                var coll = document.getElementsByClassName("collapsible");
                var i;

                for (i = 0; i < coll.length; i++) {
                    coll[i].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var content = this.nextElementSibling;
                        if (content.style.maxHeight){
                        content.style.maxHeight = null;
                        } else {
                        content.style.maxHeight = content.scrollHeight + "px";
                        } 
                    });
                }
        </script> 
        <script>
            $(document).ready(function(){
                $('.toast').toast('show');
            });
        </script>
    <?php $_SESSION['error'] = null; ?>
    </body>
</html> 