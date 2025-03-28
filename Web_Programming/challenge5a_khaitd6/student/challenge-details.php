<?php
session_start();
include('../includes/dbconnection.php');
if (strlen($_SESSION['id'])==0){
    header("Location: logout.php");
} else {
    $cid=$_GET['cid'];
    $sql="SELECT * FROM challenge WHERE cid=:id";
    $query=$dbh->prepare($sql);
    $query->bindParam(':id',$cid,PDO::PARAM_STR);
    $query->execute();
    $result=$query->fetch(PDO::FETCH_OBJ);
    $filename=$result->cname;
    $correct_ans=substr($filename,0,-4);
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Them bai tap</title>
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
                                    <h4 class="card-title" style="text-align: center;">Challenge</h4>
                                    <p>Challenge: <?php echo htmlentities($result->cname); ?> </p>
                                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                                        
                                        <div class="form-group">
                                            <label for="exampleInputName1">Goi y</label>
                                            <input type="text" name="hint" value="<?php  echo htmlentities($result->hint);?>" class="form-control" readonly='true'>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Nhap dap an</label>
                                            <input type="text" name="answer" value="" class="form-control" required='true'>
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>

                                    </form>
                                    <?php
                                        if (isset($_POST['submit'])){
                                            $ans=$_POST['answer'];
                                            if ($ans===$correct_ans) {
                                                echo '<script>alert("Dap an chinh xac")</script>';
                                                $challenge_file = "../challenge/" . $filename;
                                                $challenge_content = file_get_contents($challenge_file);
                                                echo "<p>Noi dung file challenge:</p>";
                                                echo nl2br($challenge_content);
                                            } else {
                                                echo '<script>alert("Dap an sai. Hay thu lai")</script>';
                                            }
                                        }
                                    ?>
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