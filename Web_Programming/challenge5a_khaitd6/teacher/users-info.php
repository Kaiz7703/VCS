<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
} else{
  if (isset($_POST['submit'])){
    $message=$_POST['message'];
    $senderid=$_SESSION['id'];
    $receiverid=$_GET['id'];
    echo $receiverid;
    $sql="";
    $ret="SELECT * FROM tinnhan WHERE receiver_id=:receiverid AND sender_id=:senderid";
    $query=$dbh->prepare($ret);
    $query->bindParam(':receiverid',$receiverid,PDO::PARAM_STR);
    $query->bindParam(':senderid',$senderid,PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount()>0){
      $sql="UPDATE tinnhan SET msg=:message WHERE receiver_id=:receiverid AND sender_id=:senderid";
    } else {
      $sql="INSERT INTO tinnhan(receiver_id,sender_id,msg) VALUE (:receiverid,:senderid,:message)";
    }
    $query=$dbh->prepare($sql);
    $query->bindParam(':receiverid',$receiverid,PDO::PARAM_STR);
    $query->bindParam(':senderid',$senderid,PDO::PARAM_STR);
    $query->bindParam(':message',$message,PDO::PARAM_STR);
    $query->execute();
    echo '<script>alert("Message has been added")</script>';
    echo "<script>window.location.href ='message.php'</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Thông tin người dùng</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />
    
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
     <?php include_once('includes/header.php');?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php');?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Thông tin người dùng </h3>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;"> Thông tin người dùng </h4>
                   
                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                      <?php
$id=$_GET['id'];
$sql="SELECT * FROM nguoidung WHERE id=:id";
$query = $dbh -> prepare($sql);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();
$result=$query->fetch(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{           ?>
                      <div class="form-group">
                        <label for="exampleInputName1">Họ tên</label>
                        <input type="text" name="stuname" value="<?php  echo htmlentities($result->hoten);?>" class="form-control" readonly='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Tên đăng nhập</label>
                        <input type="text" name="stuname" value="<?php  echo htmlentities($result->tendangnhap);?>" class="form-control" readonly='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Email</label>
                        <input type="text" name="stuemail" value="<?php  echo htmlentities($result->email);?>" class="form-control" readonly='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Vai trò</label>
                        <input type="text" name="role" value="<?php  echo htmlentities($result->role);?>" class="form-control" readonly='true'>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Ảnh đại diện</label>
                        <img src="../images/<?php echo $result->Image;?>" width="100" height="100" value="<?php  echo $result->Image;?>">
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Số điện thoại</label>
                        <input type="text" name="connum" value="<?php  echo htmlentities($result->sodienthoai);?>" class="form-control" readonly='true' maxlength="10" pattern="[0-9]+">
                      </div>

                      <?php
                      $senderid=$_SESSION['id'];
                      $sql="SELECT * FROM tinnhan WHERE receiver_id=:id AND sender_id=:senderid";
                      $query = $dbh -> prepare($sql);
                      $query->bindParam(':id',$id,PDO::PARAM_STR);
                      $query->bindParam(':senderid',$senderid,PDO::PARAM_STR);
                      $query->execute();
                      $result=$query->fetch(PDO::FETCH_OBJ);
                      ?>
                      <div class="form-group">
                        <label for="exampleInputName1">Để lại lời nhắn</label>
                        <input type="text" name="message" value="<?php  echo htmlentities($result->msg);?>" class="form-control" required='true'>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>             
<?php   }} ?>
                     
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->

        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>