<?php
session_start();
include('../includes/dbconnection.php');

if (isset($_POST['login'])){
    $username=$_POST['tendangnhap'];
    $password=$_POST['matkhau'];
    $sql = "SELECT id FROM nguoidung WHERE tendangnhap=:username AND matkhau=:password AND role='sinhvien'";
    $query=$dbh->prepare($sql);
    $query-> bindParam(':username', $username, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount()>0){
        foreach($results as $result){
            $_SESSION['id']=$result->id;
        }
        if (!empty($_POST["remember"])){
            //COOKIES for username
            setcookie ("user_login",$_POST["tendangnhap"],time()+ (10 * 365 * 24 * 60 * 60));
            //COOKIES for password
            setcookie ("userpassword",$_POST["matkhau"],time()+ (10 * 365 * 24 * 60 * 60));
        } else {
            if (isset($_COOKIE["user_login"])){
                setcookie("user_login","");
            }
            if (isset($_COOKIE["userpassword"])){
                setcookie("userpassword","");
            }
        }
        $_SESSION['login']=$_POST['tendangnhap'];
        echo "<script type='text/javascript'> document.location ='users-list.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Quan ly sinh vien || Dang nhap</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
        <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
        <!-- endinject -->
        <!-- Layout styles -->
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth">
                    <div class="row flex-grow">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left p-5">
                                <div class="brand-logo">
                                    <img src="../images/logo.svg">
                                </div>
                                <h4>Hello!</h4>
                                <h6 class="font-weight-light">Dang nhap de tiep tuc</h6>
                                <form class="pt-3" id="login" method="post" name="login"> 
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg" placeholder="Ten dang nhap" required="true" name="tendangnhap" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>" >
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg" placeholder="Mat khau" name="matkhau" required="true" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-success btn-block loginbtn" name="login" type="submit">Dang nhap</button>
                                    </div>
                                    <div class="my-2 d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <label class="form-check-label text-muted">
                                                <input type="checkbox" id="remember" class="form-check-input" name="remember" <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?> /> Luu dang nhap
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <a href="../index.php" class="btn btn-block btn-facebook auth-form-btn">
                                            <i class="icon-social-home mr-2"></i>Back Home</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- plugins:js -->
        <script src="vendors/js/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="js/off-canvas.js"></script>
        <script src="js/misc.js"></script>
        <!-- endinject -->
    </body>
</html>