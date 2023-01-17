<?php
include 'koneksi.php';
error_reporting(E_ALL ^ E_NOTICE);
if (isset($_POST['simpan'])) {
    $batch = $_POST['batch'];
    $class = $_POST['class'];
    $news = $_POST['news'];
    $pembicara = $_POST['pembicara'];
    $weekly = $_POST['weekly'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_akhir = $_POST['waktu_akhir'];
    $waktu_presensi = $_POST['waktu_presensi'];
    $waktu_akhir_presensi = $_POST['waktu_akhir_presensi'];
    $alarm = $_POST['ringtones'];
    $date = $_POST['date'];
    $pesan = $_POST['pesan'];
    $insert_data = mysqli_query($conn, "INSERT INTO `schedule`(`batch`, `week`, `id_activity`, `info`, `start_time`, `end_time`, `presensi_time`,`date`,`timer`,`nada_alarm`, `id_berita`, `id_trainer`) VALUES ('$batch','$weekly','$class','$pesan','$waktu_mulai','$waktu_akhir','$waktu_presensi','$date','$waktu_akhir_presensi','$alarm','$news','$pembicara')");
    echo ("<script LANGUAGE='JavaScript'>
    window.alert('Succesfully Insert');
    window.location.href='schedule.php';
    </script>");
}

?>

<!doctype html>
<html class="no-js" lang="en">
<?php
include 'session.php';
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
                                            <li><span class="bread-blod">Add Schedule</span>
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
                                <li class="active"><a href="#description">Add Schedule</a></li>
                            </ul>
                            <div id="myTabContent" class="tab-content custom-product-edit">
                                <div class="product-tab-list tab-pane fade active in" id="description">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="review-content-section">
                                                <div>
                                                    <form action="" method="POST" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <!-- <input name="firstname" type="text" class="form-control" placeholder="Full Name">
                                                                 -->
                                                                    <div class="form-group">
                                                                        <label for="">Batch :</label>
                                                                        <select name="batch" class="form-control">
                                                                            <option value="">Select Batch</option>
                                                                            <?php
                                                                            $abl_angkatan = mysqli_query($conn, "SELECT angkatan FROM `tb_angkatan` ");
                                                                            while ($dataangkatan = mysqli_fetch_array($abl_angkatan)) { ?>
                                                                                <option value="<?= $dataangkatan['angkatan']; ?>"><?= $dataangkatan['angkatan']; ?></option>
                                                                            <?php  }

                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Class :</label>
                                                                    <!-- <input name="nip" type="text" class="form-control" placeholder="Nip"> -->
                                                                    <select name="class" class="form-control">
                                                                        <option value="">Select Class</option>
                                                                        <?php
                                                                        $kelas_ = mysqli_query($conn, "SELECT * FROM `activity` ");
                                                                        while ($datakelas = mysqli_fetch_array($kelas_)) { ?>
                                                                            <option value="<?= $datakelas['id_activity']; ?>"><?= $datakelas['items']; ?></option>
                                                                        <?php  }

                                                                        ?>
                                                                    </select>

                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">News :</label>
                                                                    <select name="news" class="form-control">
                                                                        <option value="">Select News</option>
                                                                        <?php
                                                                        $berita = mysqli_query($conn, "SELECT * FROM `tb_daftar_berita` ");
                                                                        while ($databerita = mysqli_fetch_array($berita)) { ?>
                                                                            <option value="<?= $databerita['id_berita']; ?>"><?= $databerita['daftar_berita']; ?></option>
                                                                        <?php  }

                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Start Time :</label>
                                                                    <input name="waktu_mulai" type="time" class="form-control" placeholder="Start Time">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Start Time Presensi :</label>
                                                                    <input name="waktu_presensi" type="time" class="form-control" placeholder="waktu_presensi">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Ringtones :</label>
                                                                    <select name="ringtones" class="form-control">
                                                                        <option value="">Select Ringtones</option>
                                                                        <?php
                                                                        $ringtones = mysqli_query($conn, "SELECT * FROM `ringtones` ");
                                                                        while ($dataalarm = mysqli_fetch_array($ringtones)) { ?>
                                                                            <option value="<?= $dataalarm['Ringtones']; ?>"><?= $dataalarm['Ringtones']; ?></option>
                                                                        <?php  }

                                                                        ?>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <label for="">Week :</label>
                                                                    <select name="weekly" class="form-control">
                                                                        <option value="">Select Week</option>
                                                                        <option value="Orientation">Orientation</option>
                                                                        <option value="PT1">PT1</option>
                                                                        <option value="PT2">PT2</option>
                                                                        <option value="PT3">PT3</option>
                                                                        <option value="R1">R1</option>
                                                                        <option value="R2">R2</option>
                                                                        <option value="R3">R3</option>
                                                                        <option value="R4">R4</option>
                                                                        <option value="R5">R5</option>
                                                                        <option value="R6">R6</option>
                                                                        <option value="R7">R7</option>
                                                                        <option value="R8">R8</option>
                                                                        <option value="R9">R9</option>
                                                                        <option value="R10">R10</option>
                                                                        <option value="R11">R11</option>
                                                                        <option value="R12">R12</option>
                                                                        <option value="R13">R13</option>
                                                                        <option value="R14">R14</option>
                                                                        <option value="R15">R15</option>
                                                                        <option value="R16">R16</option>
                                                                        <option value="R17">R17</option>
                                                                        <option value="R18">R18</option>
                                                                        <option value="Evaluasi">Evaluasi</option>

                                                                    </select>
                                                                </div>
                                                                <div class="form-group res-mg-t-15">
                                                                    <label for="">Speaker :</label>
                                                                    <select name="pembicara" class="form-control">
                                                                        <option value="">Select Trainer</option>
                                                                        <?php
                                                                        $Trainer = mysqli_query($conn, "SELECT * FROM `trainer` ");
                                                                        while ($dataTrainer = mysqli_fetch_array($Trainer)) { ?>
                                                                            <option value="<?= $dataTrainer['id_trainer']; ?>"><?= $dataTrainer['nama_trainer']; ?></option>
                                                                        <?php  }

                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Date :</label>
                                                                    <input name="date" type="date" class="form-control" placeholder="Date">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">End Time :</label>
                                                                    <input name="waktu_akhir" type="time" class="form-control" placeholder="End Time">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Time Out Presensi :</label>
                                                                    <input name="waktu_akhir_presensi" type="time" class="form-control" placeholder="waktu_akhir_presensi">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Message :</label>
                                                                    <textarea name="pesan" id="" cols="4" rows="2" class="form-control"></textarea>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="payment-adress">
                                                                    <button name="simpan" type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
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