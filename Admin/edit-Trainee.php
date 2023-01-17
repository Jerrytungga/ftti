<?php
include 'koneksi.php';
error_reporting(E_ALL ^ E_NOTICE);
$nip = $_GET['nip'];
$data = mysqli_query($conn, "SELECT * FROM `traines`   where `nip`=$nip");
$datatranee = mysqli_fetch_array($data);
if (isset($_POST['update'])) {
    $sumber = $_FILES['imageico']['tmp_name'];
    $target = 'img/traines/';
    $foto = $_FILES['imageico']['name'];
    $name = $_POST['firstname'];
    $asi = $_POST['asisten'];
    $jenis_kelamin = $_POST['jsk'];
    $semester = $_POST['semester'];
    $batch = $_POST['batch'];
    if ($foto != '') {
        if (move_uploaded_file($sumber, $target . $foto)) {
            $edit = mysqli_query($conn, "UPDATE `traines` SET `name`='$name',`foto`='$foto',`angkatan`='$batch',`Asisten`='$asi',`gender`='$jenis_kelamin', `semester`='$semester' WHERE `nip`='$nip'");
            echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated');
    window.location.href='all_Trainess.php';
    </script>");
        }
    } else {
        $edit = mysqli_query($conn, "UPDATE `traines` SET `name`='$name',`angkatan`='$batch',`Asisten`='$asi',`gender`='$jenis_kelamin', `semester`='$semester' WHERE `nip`='$nip'");
        echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated');
    window.location.href='all_Trainess.php';
    </script>");
    }
}



include 'session.php';
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
                                            <li><span class="bread-blod">All Trainee</span>
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


        <!-- Single pro tab review Start-->
        <div class="single-pro-review-area mt-t-30 mg-b-15">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-payment-inner-st">
                            <ul id="myTabedu1" class="tab-review-design">
                                <li class="active"><a href="#description">Edit Trainee</a></li>
                            </ul>
                            <div id="myTabContent" class="tab-content custom-product-edit">
                                <div class="product-tab-list tab-pane fade active in" id="description">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="review-content-section">
                                                <div id="dropzone1" class="pro-ad">
                                                    <form action="" method="POST" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <input name="firstname" type="text" class="form-control" value="<?= $datatranee['name']; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input name="nip" type="number" class="form-control" value="<?= $datatranee['nip']; ?>" readonly>
                                                                </div>

                                                                <div class="form-group">
                                                                    <img src="img/traines/<?= $datatranee['foto']; ?>" alt="" height="150" width="150" class="mb-2">
                                                                    <p></p>
                                                                    <input name="imageico" type="file" class="form-control m-2">
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                                                <div class="form-group">
                                                                    <select name="jsk" class="form-control" value="<?= $datatranee['gender']; ?>">
                                                                        <option value="<?= $datatranee['gender']; ?>"><?php if ($datatranee['gender'] == 'B') {
                                                                                                                            echo 'Brother';
                                                                                                                        } else if ($datatranee['gender'] == 'S') {
                                                                                                                            echo 'Sister';
                                                                                                                        }; ?></option>
                                                                        <option value="B">Brother</option>
                                                                        <option value="S">Sister</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">

                                                                    <select name="batch" class="form-control">
                                                                        <option value="<?= $datatranee['angkatan']; ?>"><?= $datatranee['angkatan']; ?></option>
                                                                        <?php
                                                                        $abl_angkatan = mysqli_query($conn, "SELECT angkatan FROM `tb_angkatan` ");
                                                                        while ($dataangkatan = mysqli_fetch_array($abl_angkatan)) { ?>
                                                                            <option value="<?= $dataangkatan['angkatan']; ?>"><?= $dataangkatan['angkatan']; ?></option>
                                                                        <?php  }

                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <select name="asisten" class="form-control">
                                                                        <?php
                                                                        $asisten = mysqli_query($conn, "SELECT * FROM `asisten` ");
                                                                        while ($data_asisten = mysqli_fetch_array($asisten)) { ?>
                                                                            <option value="<?= $data_asisten['nip']; ?>"><?= $data_asisten['name']; ?></option>
                                                                        <?php  }

                                                                        ?>
                                                                        <option value="<?= $data_asisten['nip']; ?>"><?= $data_asisten['name']; ?></option>
                                                                    </select>


                                                                </div>
                                                                <div class="form-group">

                                                                    <select name="semester" class="form-control" value="<?= $datatranee['semester']; ?>">
                                                                        <?php
                                                                        $data_semester = mysqli_query($conn, "SELECT * FROM `tb_semester` ");
                                                                        while ($semester = mysqli_fetch_array($data_semester)) { ?>
                                                                            <option value="<?= $semester['thn_semester']; ?>"><?= $semester['keterangan']; ?></option>
                                                                        <?php  }
                                                                        function smt($mst)
                                                                        {
                                                                            global $conn;
                                                                            $sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_semester WHERE thn_semester='$mst'"));
                                                                            return $sql['keterangan'];
                                                                        }
                                                                        ?>
                                                                        <option value="<?= $datatranee['thn_semester']; ?>"><?= smt($datatranee['keterangan']); ?></option>
                                                                    </select>



                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="payment-adress">
                                                                    <button name="update" type="submit" class="btn btn-warning waves-effect waves-light">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
    <!-- morrisjs JS
		============================================ -->
    <script src="js/sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sparkline/jquery.charts-sparkline.js"></script>
    <!-- calendar JS
		============================================ -->
    <script src="js/calendar/moment.min.js"></script>
    <script src="js/calendar/fullcalendar.min.js"></script>
    <script src="js/calendar/fullcalendar-active.js"></script>
    <!-- maskedinput JS
		============================================ -->
    <script src="js/jquery.maskedinput.min.js"></script>
    <script src="js/masking-active.js"></script>
    <!-- datepicker JS
		============================================ -->
    <script src="js/datepicker/jquery-ui.min.js"></script>
    <script src="js/datepicker/datepicker-active.js"></script>
    <!-- form validate JS
		============================================ -->
    <script src="js/form-validation/jquery.form.min.js"></script>
    <script src="js/form-validation/jquery.validate.min.js"></script>
    <script src="js/form-validation/form-active.js"></script>
    <!-- dropzone JS
		============================================ -->
    <script src="js/dropzone/dropzone.js"></script>
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