<?php
session_start();
include('../includes/dbconnection.php');
if (strlen($_SESSION['id'])==0){
    header("Location: logout.php");
} else {
    $userid=$_SESSION['id'];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Quan ly sinh vien</title>
        <!--plugins:css-->
        <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
        <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">


        <link rel="stylesheet" href="./css/style.css">
    </head>
    <body>
        <div class="container-scroller">
            <?php include_once('includes/header.php'); ?>
            <div class="container-fluid page-body-wrapper">
                <?php include_once('includes/sidebar.php');?>
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex align-items-center mb-4">
                                            <h4 class="card-title mb-sm-0">Tin nhan da nhan</h4>
                                        </div>
                                        <div class="table-responsive border rounded p-1">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="font-weight-bold">ID</th>
                                                        <th class="font-weight-bold">Ho ten nguoi gui</th>
                                                        <th class="font-weight-bold">Loi nhan</th>
                                                        <th class="font-weight-bold">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql ="SELECT id,hoten,msg FROM nguoidung, tinnhan WHERE receiver_id=$userid AND nguoidung.id=tinnhan.sender_id";
                                                    $query=$dbh->prepare($sql);
                                                    $query->execute();
                                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount()>0){
                                                        foreach ($results as $row) {    ?>
                                                            <tr>
                                                                <td><?php  echo htmlentities($row->id);?></td>
                                                                <td><?php  echo htmlentities($row->hoten);?></td>
                                                                <td><?php  echo htmlentities($row->msg);?></td>
                                                                <td>
                                                                    <div>
                                                                        <a href="delete-msg.php?receivedmsg=<?php echo ($row->id);?>" onclick="return confirm('Do you really want to Delete ?');"> <i class="icon-trash"></i></a>
                                                                    </div>
                                                                </td>
                                                            </tr><?php
                                                        }
                                                    }   ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-sm-flex align-items-center mb-4">
                                            <h4 class="card-title mb-sm-0">Tin nhan da gui</h4>
                                        </div>
                                        <div class="table-responsive border rounded p-1">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="font-weight-bold">ID</th>
                                                        <th class="font-weight-bold">Ho ten nguoi nhan</th>
                                                        <th class="font-weight-bold">Loi nhan</th>
                                                        <th class="font-weight-bold">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql ="SELECT id,hoten,msg FROM nguoidung, tinnhan WHERE sender_id=$userid AND nguoidung.id=tinnhan.receiver_id";
                                                    $query=$dbh->prepare($sql);
                                                    $query->execute();
                                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount()>0){
                                                        foreach ($results as $row) {    ?>
                                                            <tr>
                                                                <td><?php  echo htmlentities($row->id);?></td>
                                                                <td><?php  echo htmlentities($row->hoten);?></td>
                                                                <td><?php  echo htmlentities($row->msg);?></td>
                                                                <td>
                                                                    <div>
                                                                        <a href="delete-msg.php?sentmsg=<?php echo ($row->id);?>" onclick="return confirm('Do you really want to Delete ?');"> <i class="icon-trash"></i></a>
                                                                    </div>
                                                                </td>
                                                            </tr><?php
                                                        }
                                                    }   ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- plugins:js -->
        <script src="vendors/js/vendor.bundle.base.js"></script>

        <script src="./vendors/chart.js/Chart.min.js"></script>
        <script src="./vendors/moment/moment.min.js"></script>
        <script src="./vendors/daterangepicker/daterangepicker.js"></script>
        <script src="./vendors/chartist/chartist.min.js"></script>

        <script src="js/off-canvas.js"></script>
        <script src="js/misc.js"></script>
        

    </body>
</html>
<?php } ?>