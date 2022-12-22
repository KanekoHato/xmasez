<?php
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
function generate_csrf()
{
    return md5(uniqid(mt_rand(), true));
}


if ($onserver == 1) {
    include($_SERVER['DOCUMENT_ROOT'] . '/include/dbconnection.php');
} else {
    include('./include/dbconnection.php');
}



$stmt = $stmtfind = null;
$chkundscr = "_";


if (isset($_GET['find'])) {
    if (str_contains($_GET['find'], $chkundscr)) {
        $search = '%' . $_GET['find'] . '%';
    } else {
        $splitted_name = split_name($_GET['find']);
        $search = $splitted_name['first'] . $chkundscr . $splitted_name['last'];
    }


    $search_like = $search;
    $stmtfind = $dbh->prepare("SELECT ez.id, ez.drive_lic_path, ez.ispaid, "
        . "ez.id_img_path, ez.p_name, ez.team_name, ez.p_member_1, ez.p_member_2, ez.p_member_3, ez.p_member_4, ez.qualifier, k.category "
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
    if ($onserver == 1) {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/include/head.php');
    } else {
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

        .active,
        .collapsible:hover {
            background-color: #555;
        }

        .content {
            padding: 0 18px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
            background-color: #f1f1f1;
        }

        .flying {
            position: absolute;
            z-index: 9999;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.js"></script>
</head>

<body>


    <?php

    if ($onserver == 1) {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/include/navbar.php');
    } else {
        include_once('./include/navbar.php');
    }

    ?>

    <?php
    if (isset($error) && !empty($error)) {
        foreach ($error as $error) {
    ?>
    <div class="toast flying" data-autohide="false">
        <div class="toast-header">
            <strong class="mr-auto text-primary">
                <?php echo $error['type']; ?>
            </strong>
            <small class="text-muted">Theres an
                <?php echo $error['type']; ?>
            </small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body">
            <?php echo $error['message']; ?>
        </div>
    </div>
    <?php }
    } ?>

    <div class="container pt-5">
        <div class="row mb-3">
            <div class="col-md-12">
                <form action="index.php" method="GET">
                    <div class="input-group">
                        <label for="find"></label>
                        <input type="text" name="find" placeholder="Party Leader / Your Name" class="form-control"
                            size="20" required autofocus>
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
    <?php if (isset($_GET['find']) && !empty($_GET['find'])) { ?>
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
                                            <th>Paid Status</th>
                                            <th>Qualification</th>
                                            <th>ID Card</th>
                                            <th>Driv Lic</th>
                                        </tr>
                                    </thead>
                                    <?php
        while ($row = $stmtfind->fetch()) {

            $paidplayer = $vehimgfull = $idimgfull = $shipimgfull = $drivelicimgfull = $navididimgfull = '';
            $ispaidinfo = $row['ispaid'];
            $qualifier = $row['qualifier'];

            if (isset($ispaidinfo)) {
                $paidplayer = '
                                            <div class="alert alert-primary" role="alert">
                                                Registration Fee Is : ' . $row['ispaid'] . '
                                                </div>
                                            </div>';
            }
            if (isset($qualifier)) {
                $paidplayer = '
                                            <div class="alert alert-danger" role="alert">
                                                You/Your Team Is : ' . $row['qualifier'] . '
                                                </div>
                                            </div>';
            }
            if ($row['id_img_path'] > 0) {
                $idimgfull = '<img width="50px" height="50px" src=images/' . $row['id_img_path'] . '>';
            }
            if ($row['drive_lic_path'] > 0) {
                $drivelicimgfull = '<img width="50px" height="50px" src=images/' . $row['drive_lic_path'] . '>';
            }
            
            echo '
                                                
                                                    <tr>
                                                        <td>' . $row['p_name'] . '</td>
                                                        <td>' . $row['category'] . '</td>
                                                        <td>' . $row['team_name'] . '</td>
                                                        <td>' . $row['p_member_1'] . '</td>
                                                        <td>' . $row['p_member_2'] . '</td>
                                                        <td>' . $row['p_member_3'] . '</td>
                                                        <td>' . $paidplayer . '</td>
                                                        <td>' . $qualifier . '</td>
                                                        <td><a href="images/' . $row['id_img_path'] . '" target="_blank">' . $idimgfull . '</a></td>
                                                        <td><a href="images/' . $row['drive_lic_path'] . '" target="_blank">' . $drivelicimgfull . '</a></td>
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

    <div class="modal fade" id="eventregister" tabindex="-1" role="dialog" aria-labelledby="eventregisterlabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventregister">Register To The Event</h5>
                    <button type="button" class="btn btn-secondary"
                        onclick="$('#eventregister').modal('hide')">Close</button>
                </div>
                <form action="registerevent.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_csrf" value="<?= $csrf_token ?>" />
                    <div class="modal-body">

                        <div class="form-group">
                            <div>
                                <label for="fullname">Full Name / Party Leader Name</label>
                                <input type="text" placeholder="Kaneko Hato" name="fullname" class="form-control"
                                    required autofocus>
                            </div>
                            <div>
                                <label for="event_select">Choose Event</label>
                                <select class="btn btn-primary" id="eventselect" name="event_select"
                                    class="form-select">
                                    <?php
                                    $stmt = $dbh->query('SELECT * FROM category');
                                    while ($row = $stmt->fetch()) {
                                        if ($row['id'] == 0) {
                                            echo '<option value="' . $row['id'] . '" disabled>' . $row['category'] . '</option>';

                                        } else {
                                            echo '<option value="' . $row['id'] . '">' . $row['category'] . '</option>';
                                        }

                                    }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <span for="playeridcard">Upload Your ID Picture Here</span>
                                <input class="btn btn-primary" type="file" id="playeridcard" name="idcardpicture"
                                    value="" />
                            </div>

                            <div>
                                <label for="drivinglic">Upload Your Driving License Picture Here</label>
                                <input class="btn btn-primary" type="file" id="drivinglic" name="drivinglicense"
                                    value="" />
                                <div>

                                    <div>
                                        <select class="btn btn-primary" id="teamselect" name="onteam"
                                            class="form-select">
                                            <option value="0" disabled>Are You On Team?</option>
                                            <option value="1" selected>Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>

                                    <div id="hideforrally">
                                        <label for="teamname">Team Name</label>
                                        <input placeholder="EZ Express" type="text" name="teamname"
                                            class="form-control">


                                        <label for="team1">Team Member 1 [Fishing & Paintball]</label>
                                        <input placeholder="Ensley Flameheart" type="text" name="team1"
                                            class="form-control">

                                        <div id="hideforfishing">
                                            <label for="team2">Team Member 2 [Paintball]</label>
                                            <input placeholder="Ensley Naomi" type="text" name="team2"
                                                class="form-control">

                                            <label for="team3">Team Member 3 [Paintball]</label>
                                            <input placeholder="Ensley Naoko" type="text" name="team3"
                                                class="form-control">
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    onclick="$('#eventregister').modal('hide')">Close</button>
                                <button type="submit" name="submit" value="Upload" class="btn btn-primary">Sent</button>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#eventregulation">Regulation</button>
                            </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventregulation" tabindex="-1" role="dialog" aria-labelledby="eventregulationlabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventregulation">EVENT REGULATION</h5>
                    <button type="button" class="btn btn-secondary"
                        onclick="$('#eventregulation').modal('hide')">Close</button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item">For Fishing Participant Please Fill In Only: Your Name, ID, License,
                            Team Name, Team Member 1 Field.</li>
                        <li class="list-group-item">For Offroad Participant Please Fill In Only: Your Name, ID, License
                            Field.</li>
                        <li class="list-group-item">For Paintball Participant Please Fill In Only : Your Name,ID ,
                            License, Team Name, Team Member 1,2 & 3 Field.
                        </li>
                        <li class="list-group-item">For Paintball Participant Please Fill In Only : Your Name,ID ,
                            License, Team Name, Team Member 1,2 & 3 Field.
                        </li>
                        <li class="list-group-item">You Can Register For Multiple Event, 
                            Just Re Submit Another Registration Application.
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $('#viewmyregdata').DataTable();
        });

        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            $('.toast').toast('show');
        });
        $('#modal1').modal('hide');
        $('#eventregulation').modal('hide');
    </script>
    <?php $_SESSION['error'] = null; ?>
</body>

</html>