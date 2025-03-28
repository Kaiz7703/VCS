<?php
session_start();
error_reporting(0);
include('../includes/dbconnection.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
   if(isset($_POST['submit']))
  {
    $uname=$_POST['uname'];
    $password=$_POST['password'];
    $stuname=$_POST['stuname'];
    $stuemail=$_POST['stuemail'];
    $role=$_POST['role'];
    $connum=$_POST['connum'];
    $eid=$_GET['editid'];
    $sql="update nguoidung set hoten=:stuname,email=:stuemail,role=:role,sodienthoai=:connum where id=:eid";
    $query=$dbh->prepare($sql);
    $query->bindParam(':stuname',$stuname,PDO::PARAM_STR);
    $query->bindParam(':stuemail',$stuemail,PDO::PARAM_STR);
    $query->bindParam(':role',$role,PDO::PARAM_STR);
    $query->bindParam(':connum',$connum,PDO::PARAM_STR);
    $query->bindParam(':eid',$eid,PDO::PARAM_STR);
    $query->execute();
    echo '<script>alert("Student has been updated")</script>';
    echo "<script>window.location.href ='users-list.php'</script>";
  }

  if (isset($_POST['submit-msg'])){
    $message=$_POST['message'];
    $senderid=$_SESSION['id'];
    $receiverid=$_GET['editid'];
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
    echo "<script>window.location.href ='edit-students.php?editid='+htmlentities($receiverid)</script>";
  }

  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Student  Management System|| Update Students</title>
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
              <h3 class="page-title"> Update Students </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page"> Update Students</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Update Students</h4>
                   
                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                      <?php
$eid=$_GET['editid'];
$sql="SELECT * FROM nguoidung WHERE id=:eid";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                      <div class="form-group">
                        <label for="exampleInputName1">Student Name</label>
                        <input type="text" name="stuname" value="<?php  echo htmlentities($row->hoten);?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Student Email</label>
                        <input type="text" name="stuemail" value="<?php  echo htmlentities($row->email);?>" class="form-control" required='true'>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Vai tro</label>
                        <select name="role" value="" class="form-control" required='true'>
                          <option value="<?php  echo htmlentities($row->role);?>"><?php  echo htmlentities($row->role);?></option>
                          <option value="sinhvien">Sinh vien</option>
                          <option value="giaovien">Giao vien</option>
                        </select>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Anh dai dien</label>
                        <img src="../images/<?php echo $row->Image;?>" width="100" height="100" value="<?php  echo $row->Image;?>"><a href="changeimage.php?id=<?php echo $row->id;?>"> &nbsp; Edit Image</a>
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Contact Number</label>
                        <input type="text" name="connum" value="<?php  echo htmlentities($row->sodienthoai);?>" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>
                      
                      
                      <h3>Login details</h3>
                      <div class="form-group">
                        <label for="exampleInputName1">User Name</label>
                        <input type="text" name="uname" value="<?php  echo htmlentities($row->tendangnhap);?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Password</label>
                        <input type="Password" name="password" value="<?php  echo htmlentities($row->matkhau);?>" class="form-control" required='true'>
                      </div><?php $cnt=$cnt+1;}} ?>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>


                    </form>
                    
                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                      <h3>Để lại lời nhắn</h3>
                        <?php
                          $senderid=$_SESSION['id'];
                          $msg_sql="SELECT * FROM tinnhan WHERE receiver_id=:eid AND sender_id=:senderid";
                          $q = $dbh -> prepare($msg_sql);
                          $q->bindParam(':eid',$eid,PDO::PARAM_STR);
                          $q->bindParam(':senderid',$senderid,PDO::PARAM_STR);
                          $q->execute();
                          $res=$q->fetch(PDO::FETCH_OBJ);
                        ?>
                        <div class="form-group">
                          <input type="text" name="message" value="<?php  echo htmlentities($res->msg);?>" class="form-control" required='true'>
                        </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit-msg">Add</button> 
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
