<?php
  $aid=$_SESSION['id'];
  $img_sql="SELECT Image FROM nguoidung WHERE id=:aid";
  $q=$dbh->prepare($img_sql);
  $q->bindParam(':aid',$aid,PDO::PARAM_STR);
  $q->execute();
  $res=$q->fetch(PDO::FETCH_OBJ);
  $image="";
  if (isset($res->Image)){
    $image=$res->Image;
  } else {
    $image="faces/face8.jpg";
  }
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="../images/<?php echo $image;?>" alt="profile image">
                  <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
<?php
  $sql="SELECT * from nguoidung where id=:aid AND role='giaovien'";

  $query = $dbh -> prepare($sql);
  $query->bindParam(':aid',$aid,PDO::PARAM_STR);
  $query->execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                  <p class="profile-name"><?php  echo htmlentities($row->hoten);?></p>
                  <p class="designation"><?php  echo htmlentities($row->email);?></p><?php $cnt=$cnt+1;}} ?>
                </div>
               
              </a>
            </li>
            <li class="nav-item nav-category">
              <span class="nav-link">Dashboard</span>
            </li>
            
            

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
                <span class="menu-title">Danh sách người dùng</span>
                <i class="icon-people menu-icon"></i>
              </a>
              <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="users-list.php">Danh sách</a></li>
                  <li class="nav-item"> <a class="nav-link" href="add-users.php">Thêm người dùng</a></li>
                  <li class="nav-item"> <a class="nav-link" href="message.php">Tin nhắn</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <span class="menu-title">Bài tập</span>
                <i class="icon-people menu-icon"></i>
              </a>
              <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="homework-list.php">Danh sách bài tập</a></li>
                  <li class="nav-item"> <a class="nav-link" href="add-homework.php">Thêm bài tập</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#auth1" aria-expanded="false" aria-controls="auth1">
                <span class="menu-title">Challenge</span>
                <i class="icon-people menu-icon"></i>
              </a>
              <div class="collapse" id="auth1">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="challenge-list.php">Danh sách challenge</a></li>
                  <li class="nav-item"> <a class="nav-link" href="add-challenge.php">Thêm challenge</a></li>
                </ul>
              </div>
            </li>
            
            
          </ul>
        </nav>