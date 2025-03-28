<?php
session_start();
include('../includes/dbconnection.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
    $adminid=$_SESSION['id'];
    if(isset($_POST['submit']))
  {
    $adminid=$_SESSION['id'];
    $AName=$_POST['adminname'];
    $uname=$_POST['username'];
  $mobno=$_POST['mobilenumber'];
  $email=$_POST['email'];
  $sql="update nguoidung set tendangnhap=:username,hoten=:adminname,sodienthoai=:mobilenumber,email=:email where id=:aid";
     $query = $dbh->prepare($sql);
     $query->bindParam(':username',$uname,PDO::PARAM_STR);
     $query->bindParam(':adminname',$AName,PDO::PARAM_STR);
     $query->bindParam(':email',$email,PDO::PARAM_STR);
     $query->bindParam(':mobilenumber',$mobno,PDO::PARAM_STR);
     $query->bindParam(':aid',$adminid,PDO::PARAM_STR);
$query->execute();

    echo '<script>alert("Your profile has been updated")</script>';
    echo "<script>window.location.href ='manage-students.php'</script>";

  }
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Student  Management System|| Profile</title>
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
              <h3 class="page-title"> Admin Profile </h3>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Thông tin giáo viên</h4>
                   
                    <form class="forms-sample" method="post">
                      <?php

$sql="SELECT * from  nguoidung WHERE role='giaovien' AND id=$adminid";
$query = $dbh -> prepare($sql);
$query->execute();
$result=$query->fetch(PDO::FETCH_OBJ);
//$cnt=1;
if($query->rowCount() > 0)
{             ?>
                      <div class="form-group">
                        <label for="exampleInputName1">Họ tên giáo viên</label>
                        <input type="text" name="adminname" value="<?php  echo $result->hoten;?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Tên đăng nhập</label>
                        <input type="text" name="username" value="<?php  echo $result->tendangnhap;?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword4">Số điện thoại</label>
                        <input type="text" name="mobilenumber" value="<?php  echo $result->sodienthoai;?>"  class="form-control" maxlength='10' required='true' pattern="[0-9]+">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputCity1">Email</label>
                         <input type="email" name="email" value="<?php  echo $result->email;?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Ảnh đại diện</label>
                        <img src="../images/<?php echo $result->Image;?>" width="100" height="100" value="<?php  echo $result->Image;?>"><a href="changeimage.php?id=<?php echo $result->id;?>"> &nbsp; Sửa ảnh</a>
                      </div>
                      <?php } ?> 
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Cập nhật</button>
                     
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
</html><?php }  ?>