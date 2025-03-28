<?php
session_start();
include('../includes/dbconnection.php');
if (strlen($_SESSION['id'])==0){
    header("Location: logout.php");
} else {
    if (isset($_GET['delid'])) {
        $rid=$_GET['delid'];
        $sql="delete from nguoidung where id=$rid";
        //$sql="INSERT INTO nguoidung(id,tendangnhap,hoten,matkhau,email,sodienthoai,role) VALUES ($rid,'thai','Hoang Van Thai','hvt','hvt@gmail.com','0879102003','sinhvien')";
        //$query->bindParam(':rid',$rid,PDO::PARAM_STR);
        $query=$dbh->prepare($sql);
        $query->execute();
        //$results=$query->fetchAll(PDO::FETCH_OBJ);
        echo "<script>alert('Data deleted');</script>";
        echo "<script>window.location.href='manage-students.php'</script>";
    } 
    /*
    else if (isset($_GET['delmsg'])) {
        $userid=$_SESSION['id'];
        $senderid=$_GET['delmsg'];
        $sql = "delete from tinnhan where receiver_id=$userid AND sender_id=$senderid";
        $query=$dbh->prepare($sql);
        $query->execute();
        echo "<script>alert('Message deleted');</script>";
        echo "<script>window.location.href='message.php'</script>";
    }*/
}
?>