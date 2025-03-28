<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="profile-image">
                    <img class="img-xs rounded-circle" src="../images/faces/face8.jpg" alt="profile image">
                    <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                    <?php
                    $aid=$_SESSION['id'];
                    $sql="SELECT * FROM nguoidung WHERE id=:aid AND role='giaovien'";
                    $query=$dbh->prepare($sql);
                    $query->bindParam(':aid',$aid,PDO::PARAM_STR);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);

                    $cnt=1;
                    if ($query->rowCount()>0){
                        foreach($results as $row){
                    ?>
                            <p class="profile-name"><?php  echo htmlentities($row->hoten);?></p>
                            <p class="designation"><?php  echo htmlentities($row->Email);?></p>
                            <?php $cnt=$cnt+1;
                        }
                    }
                    ?>
                </div>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
            <span class="menu-title">Students</span>
                <i class="icon-people menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basics1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="add-users.php">Them nguoi dung</a></li>
                    <li class="nav-item"> <a class="nav-link" href="manage-students.php">Danh sach sinh vien</a></li>
                </ul>
            </div>
        </li>

        
                    
    </ul>
</nav>