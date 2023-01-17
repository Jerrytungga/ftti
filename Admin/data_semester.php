<?php
include 'koneksi.php';
error_reporting(E_ALL ^ E_NOTICE);
if (isset($_POST['save'])) {
    $idsemester = $_POST['idsemester'];
    $keterangan = $_POST['keterangan'];
    $semester = mysqli_query($conn, "INSERT INTO `tb_semester`(`thn_semester`, `keterangan`) VALUES ('$idsemester','$keterangan')");
?>
    <script>
        alert("Data Berhasil ditambahkan!!");
    </script>
<?php
}
if (isset($_POST['thn'])) {
    $jd =  $_POST['nonaktifkan'];
    $jd2 =  $_POST['aktif'];
    $id =  $_POST['thn'];
    if ($_POST['nonaktifkan']) {
        $menu = mysqli_query($conn, "UPDATE `tb_semester` SET `status` = '$jd' WHERE `tb_semester`.`thn_semester` = '$id'");
    } else {
        $menu = mysqli_query($conn, "UPDATE `tb_semester` SET `status` = '$jd2' WHERE `tb_semester`.`thn_semester` = '$id'");
    }
}
include 'session.php';
$data = mysqli_query($conn, "SELECT * FROM `tb_semester` ");
$data_semester = mysqli_fetch_array($data);
?>
<!doctype html>
<html class="no-js" lang="en">
<?php
include 'head.php';
?>


<body>
    <?php
    include 'sidebar.php';
    ?>
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="logo-pro">
                        <a href="index.html"><img class="main-logo" src="img/logo/logo.png" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-advance-area">
            <?php
            include 'menu_header.php';
            include 'mode_mobile.php';
            ?>
            <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list single-page-breadcome">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <!-- <div class="breadcome-heading">
                                            <form role="search" class="sr-input-func">
                                                <input type="text" placeholder="Search..." class="search-int form-control">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                            </form>
                                        </div> -->
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <ul class="breadcome-menu">
                                            <li><a href="#">Home</a> <span class="bread-slash">/</span>
                                            </li>
                                            <li><span class="bread-blod">Semester</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Static Table Start -->
        <div class="static-table-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline8-list">
                            <div class="sparkline8-hd">
                                <div class="main-sparkline8-hd">
                                    <h1>Table Semester</h1>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        Add Semester
                                    </button>

                                </div>
                            </div>
                            <div class="sparkline8-graph">
                                <div class="static-table-list">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($data as $row) :
                                            ?>

                                                <tr>

                                                    <td><?= $i; ?></td>
                                                    <td><?= $row['keterangan'];  ?></td>
                                                    <td> <?php
                                                            if ($row['status'] == "Aktif") { ?>
                                                            <button type="button" class="btn btn-custon-rounded-four btn-success"><?= $row['status'];  ?></button>
                                                        <?php    } else { ?>
                                                            <button type="button" class="btn btn-custon-rounded-four btn-danger"><?= $row['status'];  ?></button>
                                                        <?php  }
                                                        ?></button>
                                                    </td>
                                                    <td>

                                                        <form action="" method="POST">

                                                            <input type="hidden" name="thn" value="<?= $row['thn_semester']; ?>">
                                                            <?php
                                                            if ($row['status'] == "Aktif") { ?>
                                                                <button type="submit" value="Tidak Aktif" name="nonaktifkan" class="btn btn-danger">Nonaktifkan</button>
                                                            <?php    } else { ?>
                                                                <button type="submit" value="Aktif" name="aktif" class="btn btn-success">Aktifkan</button>
                                                            <?php  }
                                                            ?>
                                                        </form>
                                                    </td>

                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>


            </div>
        </div>
        <p></p>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Semester</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div>
                                <label for="">ID Semester :</label>
                                <input type="text" class="form-control" name="idsemester" placeholder="contoh : 20221">
                            </div>
                            <br>
                            <div>
                                <label for="">Keterangan :</label>
                                <input type="text" class="form-control" name="keterangan" placeholder="contoh : semester 1">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="save" class="btn btn-primary">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Static Table End -->
        <div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-copy-right">
                            <p>Copyright © 2018. All rights reserved. Template by <a href="https://colorlib.com/wp/templates/">Colorlib</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery
		============================================ -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- wow JS
		============================================ -->
    <script src="js/wow.min.js"></script>
    <!-- price-slider JS
		============================================ -->
    <script src="js/jquery-price-slider.js"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="js/jquery.meanmenu.js"></script>
    <!-- owl.carousel JS
		============================================ -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- sticky JS
		============================================ -->
    <script src="js/jquery.sticky.js"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/scrollbar/mCustomScrollbar-active.js"></script>
    <!-- metisMenu JS
		============================================ -->
    <script src="js/metisMenu/metisMenu.min.js"></script>
    <script src="js/metisMenu/metisMenu-active.js"></script>
    <!-- peity JS
		============================================ -->
    <script src="js/peity/jquery.peity.min.js"></script>
    <script src="js/peity/peity-active.js"></script>
    <!-- sparkline JS
		============================================ -->
    <script src="js/sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sparkline/sparkline-active.js"></script>
    <!-- tab JS
		============================================ -->
    <script src="js/tab.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="js/main.js"></script>
    <!-- tawk chat JS
		============================================ -->
    <script src="js/tawk-chat.js"></script>
</body>

</html>