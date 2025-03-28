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
        <title>Danh sach bai tap</title>
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
                            <h3 class="page-title">Danh sach bai tap</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive border rounded p-1">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="font-weight-bold">Task ID</th>
                                                        <th class="font-weight-bold">Bài tập</th>
                                                        <th class="font-weight-bold">Tải xuống</th>
                                                        <th class="font-weight-bold">Bài làm</th>
                                                        <th class="font-weight-bold">Nộp bài</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (isset($_GET['pageno'])){
                                                        $pageno = $_GET['pageno'];
                                                    } else {
                                                        $pageno = 1;
                                                    }
                                                    $no_of_records_per_page = 15;
                                                    $offset = ($pageno-1) * $no_of_records_per_page;
                                                    $ret = "SELECT task_id FROM baitap";
                                                    $query1 = $dbh->prepare($ret);
                                                    $query1->execute();
                                                    $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                                    $total_rows=$query1->rowCount();
                                                    $total_pages=ceil($total_rows/$no_of_records_per_page);
                                                    $sql ="SELECT * FROM baitap LIMIT $offset,$no_of_records_per_page";
                                                    $query=$dbh->prepare($sql);
                                                    $query->execute();
                                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount()>0){
                                                        foreach ($results as $row) {    ?>
                                                            <tr>
                                                                <td><?php  echo htmlentities($row->task_id);?></td>
                                                                <td><?php  echo htmlentities($row->filename);?></td>
                                                                <td>
                                                                    <div><a href="../baitap/<?php echo htmlentities($row->filename);?>" download>Download</a>
                                                                    </div>
                                                                </td>
                                                        <?php
                                                            $solution="SELECT * FROM bailam WHERE task_id=:taskid AND student_id=:userid";
                                                            $q=$dbh->prepare($solution);
                                                            $q->bindParam(':taskid',$row->task_id,PDO::PARAM_STR);
                                                            $q->bindParam(':userid',$userid,PDO::PARAM_STR);
                                                            $q->execute();
                                                            $res=$q->fetch(PDO::FETCH_OBJ);
                                                            if ($q->rowCount()>0){ ?>
                                                                <td>
                                                                    <div><a href="../bailam/<?php echo htmlentities($res->filename);?>" download>Đã hoàn thành</a>
                                                                    </div>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td><?php echo "Chưa hoàn thành"; ?></td>
                                                            <?php } ?>
                                                                
                                                                <td>
                                                                    <a href="add-solve.php?tid=<?php echo htmlentities($row->task_id);?>"> &nbsp; Thêm bài làm </a>
                                                                </td>
                                                            </tr><?php
                                                        }
                                                    }   ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div align="left">
                                            <ul class="pagination">
                                                <li><a href="?pageno=1"><strong>First></strong></a></li>
                                                <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                                    <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><strong style="padding-left: 10px">Prev></strong></a>
                                                </li>
                                                <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                                    <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><strong style="padding-left: 10px">Next></strong></a>
                                                </li>
                                                <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a></li>
                                            </ul>
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
