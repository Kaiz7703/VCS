<?php
session_start();
include('../includes/dbconnection.php');
if (strlen($_SESSION['id'])==0){
    header("Location: logout.php");
} else {
    if(isset($_POST['submit'])) {
            $uid=$_GET['id'];
            $image=$_FILES["image"]["name"];
            $extension = substr($image,strlen($image)-4,strlen($image));
            $allowed_extensions = array(".jpg","jpeg",".png",".gif");
        if(!in_array($extension,$allowed_extensions)) {
            echo "<script>alert('Invalid format. Only .jpg / jpeg / .png / .gif format allowed');</script>";
        } else { 
            $image=md5($image).time().$extension;
            move_uploaded_file($_FILES["image"]["tmp_name"],"../images/".$image);
            $sql="UPDATE nguoidung SET Image=:image  WHERE id=:uid";
            $query=$dbh->prepare($sql);
            $query->bindParam(':image',$image,PDO::PARAM_STR);
            $query->bindParam(':uid',$uid,PDO::PARAM_STR);
            $query->execute();
            echo '<script>alert("Image has been editted.")</script>';
            echo "<script>window.location.href ='users-list.php'</script>";
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sua anh dai dien</title>
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
                                    <h4 class="card-title" style="text-align: center;">Thay anh dai dien</h4>
                                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputName1">Anh dai dien</label>
                                            <input type="file" name="image" value="" class="form-control" required='true'>
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Edit</button>

                                    </form>
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