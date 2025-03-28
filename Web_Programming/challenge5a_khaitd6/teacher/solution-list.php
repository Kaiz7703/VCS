<?php
session_start();
include('../includes/dbconnection.php');
if (strlen($_SESSION['id'])==0){
    header("Location: logout.php");
} else {
    $tid=$_GET['tid'];    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Danh sach bai lam</title>
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
                        <div class="page-header">
                            <h3 class="page-title">Danh sach bai lam</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive border rounded p-1">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="font-weight-bold">ID Sinh Viên</th>
                                                        <th class="font-weight-bold">Họ tên sinh viên</th>
                                                        <th class="font-weight-bold">Bài làm</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    
                                                    $sql ="SELECT id,hoten,filename FROM nguoidung, bailam WHERE nguoidung.id=bailam.student_id AND bailam.task_id=:tid";
                                                    $query=$dbh->prepare($sql);
                                                    $query->bindParam(':tid',$tid,PDO::PARAM_STR);
                                                    $query->execute();
                                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount()>0){
                                                        foreach ($results as $row) {    ?>
                                                            <tr>
                                                                <td><?php  echo htmlentities($row->id);?></td>
                                                                <td><?php  echo htmlentities($row->hoten);?></td>
                                                                <td>
                                                                    <div><a href="../bailam/<?php echo htmlentities($row->filename);?>" download><?php echo htmlentities($row->filename) ?></a>
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
