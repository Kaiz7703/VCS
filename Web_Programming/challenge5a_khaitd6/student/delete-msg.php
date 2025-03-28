<?php
session_start();
include('../includes/dbconnection.php');
if (strlen($_SESSION['id'])==0){
    header("Location: logout.php");
} else {
    if (isset($_GET['receivedmsg'])) {
        $userid=$_SESSION['id'];
        $senderid=$_GET['receivedmsg'];
        $sql = "delete from tinnhan where receiver_id=$userid AND sender_id=$senderid";
        $query=$dbh->prepare($sql);
        $query->execute();
        echo "<script>alert('Message deleted');</script>";
        echo "<script>window.location.href='message.php'</script>";
    } else if (isset($_GET['sentmsg'])){
        $userid=$_SESSION['id'];
        $receiverid=$_GET['sentmsg'];
        $sql = "delete from tinnhan where sender_id=$userid AND receiver_id=$receiverid";
        $query=$dbh->prepare($sql);
        $query->execute();
        echo "<script>alert('Message deleted');</script>";
        echo "<script>window.location.href='message.php'</script>";
    }
}
?>