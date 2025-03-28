<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center">
    </div>
    <?php
        $aid=$_SESSION['id'];
        $sql="SELECT * FROM nguoidung WHERE id=:aid AND role='giaovien'";
        $query=$dbh->prepare($sql);
        $query->bindParam(':aid',$aid,PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1;
        if ($query->rowCount()>0){
            foreach ($results as $row){     ?>
                <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
                    <h5 class="mb-0 font-weight-medium d-none d-lg-flex"><?php echo htmlentities($row->hoten);?> Welcome! </h5>
                    <ul class="navbar-nav navbar-nav-right ml-auto">
                        <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
                            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                            <?php
                                $image="";
                                if (isset($row->Image)){
                                    $image=$row->Image;
                                } else {
                                    $image="/faces/face8.jpg";
                                }
                            ?>
                            <img class="img-xs rounded-circle ml-2" src="../images/<?php echo $image;?>" alt="Profile image"> <span class="font-weight-normal"> <?php  echo htmlentities($row->hoten);?> </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                                <div class="dropdown-header text-center">
                                <img class="img-md rounded-circle" src="../images/<?php echo $image;?>" alt="Profile image">
                                <p class="mb-1 mt-3"><?php  echo htmlentities($row->hoten);?></p>
                                <p class="font-weight-light text-muted mb-0"><?php  echo htmlentities($row->email);?></p>
                                </div><?php $cnt=$cnt+1;
            }
        }?>
                                <a class="dropdown-item" href="profile.php"><i class="dropdown-item-icon icon-user text-primary"></i>Thông tin cá nhân</a>
                                <a class="dropdown-item" href="change-password.php"><i class="dropdown-item-icon icon-energy text-primary"></i>Đổi mật khẩu</a>
                                <a class="dropdown-item" href="logout.php"><i class="dropdown-item-icon icon-power text-primary"></i>Đăng xuất</a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="icon-menu"></span>
                    </button>
                </div>
</nav>